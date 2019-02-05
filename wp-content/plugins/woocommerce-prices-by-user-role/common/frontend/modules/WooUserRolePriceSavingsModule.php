<?php

class WooUserRolePriceSavingsModule extends AbstractWooUserRoleModule
{
    public function onShowVariationPriceForCustomerSavings($isShow)
    {
        if ($this->_isShowCustomerSavingsOnProductPage()) {
            return true;
        }

        if ($this->_hasEqualRegularPriceinVariations()) {
            return true;
        }

        return $isShow;
    } // end onShowVariationPriceForCustomerSavings
    
    private function _isShowCustomerSavingsOnProductPage()
    {
        $settings = $this->engine->getSettings();
        
        return !empty($settings) &&
               array_key_exists('showCustomerSavings', $settings) && 
               in_array('product', $settings['showCustomerSavings']);
    } // end _isShowCustomerSavingsOnProductPage
    
    private function _hasEqualRegularPriceInVariations()
    {
        $idProduct = $this->engine->getMainProductID();

        if (!$idProduct) {
            return false;
        }

        $product = $this->engine->createProductInstance($idProduct);

        $variableProduct = new FestiWooCommerceVariableProduct($product);

        $productsIDs = $variableProduct->getChildren($product);

        foreach ($productsIDs as $id) {

            $product = $this->engine->createProductInstance($id);
            $regularPrice = $this->engine->products->getRegularPrice($product);

            if (isset($previousPrice) && $previousPrice != $regularPrice) {
                return false;
            }

            $previousPrice = $regularPrice;
        }

        return true;
    } // _hasEqualRegularPriceInVariations
    
    public function hasConditionsForDisplayCustomerSavingsInProduct($product)
    {
        if (!$this->_hasNewPriceForProduct($product)) {
            return false;
        }

        return $this->engine->hasOptionInSettings('showCustomerSavings')
               && $this->engine->isRegisteredUser()
               && $this->_isAllowedPageToDisplayCustomerSavings($product)
               && $this->_isAvaliableProductTypeToDispalySavings($product);
    } // end _hasConditionsForDisplayCustomerSavingsInProduct
    
    private function _hasNewPriceForProduct($product)
    {
        if ($this->engine->isVariableTypeProduct($product)) {
            return $this->_hasNewPriceForRangeProduct($product);
        }
        
        $idProduct = $this->engine->products->getProductId($product);
        $rolePrice = $this->engine->getRolePrice($idProduct);
        $hasDiscount = $this->engine->
            hasDiscountOrMarkUpForUserRoleInGeneralOptions();
        
        return $rolePrice ||
               ($hasDiscount && !$this->engine
                    ->isIgnoreDiscountForProduct($idProduct));
    } // end _hasNewPriceForProduct
    
    private function _hasNewPriceForRangeProduct($product)
    {
        $productsIDs = $product->get_children();
        $flag = false;
        
        if ($productsIDs) {
            foreach ($productsIDs as $id) {
                $product = $this->engine->createProductInstance($id);
                $hasNewPrice = $this->engine->products->getUserPrice($product);
                if ($hasNewPrice) {
                    $flag = true;
                    break;
                }
            }
        }
        return $flag;
    } // end _hasNewPriceForRangeProduct
    
    private function _isAllowedPageToDisplayCustomerSavings($product)
    {
        $isEnabledProductPage = $this->_isEnabledPageInCustomerSavingsOption(
            'product'
        );
        
        $isEnabledArchivePage = $this->_isEnabledPageInCustomerSavingsOption(
            'archive'
        );
        
        $mainProduct = $this->_isMainProductInSimpleProductPage($product);
        
        $engine = &$this->engine;
        $isProductPage = $engine->isProductPage();
        
        if ($isProductPage && $isEnabledProductPage && $mainProduct) {
            return true;
        }

        if (!$isProductPage && $isEnabledArchivePage) {
            return true;
        }
        
        if ($engine->isProductParentMainproduct($product, $mainProduct)) {
            return true;
        }

        return false;
    } // end _isAllowedPageToDisplayCustomerSavings
    
    private function _isMainProductInSimpleProductPage($product)
    {
        $engine = &$this->engine;
        $idProduct = $this->ecommerceFacade->getProductID($product);
        return $idProduct == $engine->getMainProductOnPage();
    } // end _isMainProductInSimpleProductPage
    
    private function _isAvaliableProductTypeToDispalySavings($product)
    {
        $engine = &$this->engine;
        $result = $engine->products->isAvaliableProductTypeToDispalySavings(
            $product
        );
        
        return $result;
    } // end _isAvaliableProductTypeToDispalySavings
    
    public function onDisplayCustomerSavingsFilter($product)
    {
        $engine = &$this->engine;
        $regularPrice = $engine->products->getRegularPrice($product, true);
        
        $userPrice = $engine->products->getUserPrice($product, true);
        
        $result = $this->_isAvaliablePricesToDisplayCustomerSavings(
            $regularPrice,
            $userPrice
        );
        
        if (!$result) {
            return $price;
        }
        
        $regularPriceSuffix = $this->_getSuffixForRegularPrice($product);
        
        $userDiscount = $this->_fetchUserDiscount(
            $regularPrice,
            $userPrice,
            $product
        );
        $regularPrice = $engine->getFormattedPrice($regularPrice);
        $formattedPrice = $engine->getFormattedPrice($userPrice);
        
        $userPrice = $engine->fetchPrice(
            $formattedPrice,
            WooUserRolePricesFrontendFestiPlugin::TYPE_PRICE_USER
        );
        
        $vars = array(
            'regularPrice'       => $engine->fetchPrice($regularPrice),
            'userPrice'          => $userPrice,
            'userDiscount'       => $userDiscount,
            'priceSuffix'        => $engine->products->getPriceSuffix($product),
            'regularPriceSuffix' => $regularPriceSuffix
        );

        if ($this->_isSubcribePluginProducts($product)) {
            $content = $engine->fetch(
                'customer_subscription_product_savings_price.phtml', 
                $vars
            );
            
            return $content;
        }
        
        if (!$userPrice) {
            return $this->_fetchFreePrice($price);
        }

        return $engine->fetch('customer_product_savings_price.phtml', $vars);
    }
    
    private function _isAvaliablePricesToDisplayCustomerSavings(
        $regularPrice, $userPrice
    )
    {
        return $userPrice < $regularPrice;
    } // end _isAvaliablePricesToDisplayCustomerSavings
    
    private function _getSuffixForRegularPrice($product)
    {
        return $this->engine->products->getPriceSuffix(
            $product,
            $this->_getRegularPriceBeforeAnyTaxCalculationsProcessed($product)
        );
    } // end _getSuffixForRegularPrice
    
    private function _getRegularPriceBeforeAnyTaxCalculationsProcessed($product)
    {
        return $this->engine->products->getRegularPrice($product, false);
    } // end _getRegularPriceBeforeAnyTaxCalculationsProcessed
    
    private function _fetchUserDiscount($regularPrice, $userPrice, $product)
    {
        $discount = round(100 - ($userPrice/$regularPrice * 100), 2);
        
        $vars = array(
            'discount' => $discount
        );

        return $this->engine->fetch('discount.phtml', $vars);
    } // end _fetchUserDiscount
    
    private function _fetchFreePrice($price)
    {
        if ($this->engine->hasDiscountOrMarkUpForUserRoleInGeneralOptions()) {
            return $price;
        }
        
        return $this->engine->fetch('free.phtml');
    } // end _fetchFreePrice
    
    public function onDisplayCustomerTotalSavingsFilter($total)
    {
        $engine = &$this->engine;
        if (!$engine->hasOptionInSettings('showCustomerSavings')
            || !$this->_isEnabledPageInCustomerSavingsOption('cartTotal')
            || !$engine->isRegisteredUser()) {
            return $total;
        }
        
        $cart = WooCommerceCartFacade::getInstance();

        $userTotal = $cart->getTotal(); 
        $retailTotal = $this->getRetailTotal();
        $isGeneralTotals = $engine->mainTotals;
        
        if ($this->_isSubscriptionInCart($cart)) {
            $this->setSubscriptionProductOption($cart);
            $userTotal = $this->getUserTotalWithSubscription($userTotal);
            $retailTotal = $this->getTotalRetailWithSubscription(
                $retailTotal, 
                $cart
            );
            $engine->mainTotals = false;
        }
        
        if (!$this->_isRetailTotalMoreThanUserTotal($retailTotal, $userTotal)) {
            return $total;
        }

        $totalSavings = $this->_getTotalSavings($retailTotal, $userTotal);

        $userTotal = $engine->getFormattedPrice($userTotal);
        $retailTotal = $engine->getFormattedPrice($retailTotal);
        
        $userPrice = $engine->fetchPrice(
            $userTotal,
            WooUserRolePricesFrontendFestiPlugin::TYPE_PRICE_USER
        );
        
        $vars = array(
            'regularPrice'    => $engine->fetchPrice($retailTotal),
            'userPrice'       => $userPrice,
            'userDiscount'    => $this->_fetchTotalSavings(
                $totalSavings
            ),
            'isGeneralTotals' => $isGeneralTotals
        );
        
        if ($isGeneralTotals && $this->_hasSubscriptionFee()) {
            $vars['fee'] = $engine->getFormattedPrice($engine->subscriptionFee);
        }
        
        return $engine->fetch('customer_total_savings_price.phtml', $vars);
    } // end onDisplayCustomerTotalSavingsFilter
    
    private function _isEnabledPageInCustomerSavingsOption($page)
    {
        $settings = $this->engine->getSettings();
        return in_array($page, $settings['showCustomerSavings']);
    } // end _isEnabledPageInCustomerSavingsOption
    
    public function getRetailTotal()
    {
        $retailSubTotal = $this->getRetailSubTotalWithTax();
        $shippingTotal = $this->_getShippingTotalWithTax();
        $retailTotal = $retailSubTotal + $shippingTotal;
        return $retailTotal;
    } // end getRetailTotal
    
    public function getRetailSubTotalWithTax()
    {
        $cart = WooCommerceCartFacade::getInstance();
        
        $subtotal = $cart->getTotalFullPrice(); 
        
        $taxTotal = $cart->getTaxTotal();

        $taxPersent = $this->_getTaxTotalPersent($subtotal, $taxTotal);
        
        $this->engine->taxPersent = $taxPersent;
        
        $retailSubTotal = $this->getRetailSubTotal();
        
        $retailSubTotalTax = $retailSubTotal / 100 * $taxPersent;
        
        $retailSubTotalWithTax = $retailSubTotal;
        
        if ($this->_isTaxExcludedFromPriceAndDisplaysSeparately($cart)) {
            $retailSubTotalWithTax += $retailSubTotalTax;
        }
        
        return $retailSubTotalWithTax;
    } // end getRetailSubTotalWithTax
    
    public function getUserTotalWithSubscription($total)
    {
        $engine = &$this->engine;
        $product = $engine->subscribeProduct;
        
        if (!$engine->mainTotals) {
            $userPrice = $this->_getUserPriceForSubscriptions($product);
            $userPrice = $userPrice * $engine->subscriptionCount;
            $userPrice += $this->_getShippingTotalWithTax();
            $subscriptionTax = $engine->subscriptionTax;
            $userPrice = $userPrice * $subscriptionTax / 100 + $userPrice;
            
            return $userPrice;
        }
        
        if ($engine->subscriptionFee) {
            $total = $total - $engine->subscriptionFee;
        }
        
        return $total;
    } // end getUserTotalWithSubscription
    
    public function getTotalRetailWithSubscription($total, $cart)
    {
        $engine = &$this->engine;
        $product = $engine->subscribeProduct;

        $shippingCost = $this->_getShippingCost($cart);
        
        if (!$engine->mainTotals) {
            
            $regularPrice = $this->_getRegularPriceForSubscription($product);
            $regularPrice += $shippingCost;
            
            $priceWidthTax = $regularPrice * $engine->subscriptionTax / 100;
            $priceWidthTax += $regularPrice;
            
            $regularPrice = $priceWidthTax * $engine->subscriptionCount;
            return $regularPrice; 
        }
        
        $isTrial = $this->_isTrialSubscription($product);
        
        if ($isTrial) {
            $price = $this->subscriptionPrice * $engine->subscriptionCount;
            $total = $total - $price;
        }
        
        if ($this->isOnlySubscriptionInCart($cart) || !$isTrial) {
            return $total;
        }
        
        $total = $this->_getTotalRetailWithoutSubscription($cart);
        
        $total += $shippingCost;
        return $total;
    } // end getTotalRetailWithSubscription
    
    private function _getTaxTotalPersent($subtotal, $taxTotal)
    {
        if ($subtotal == 0) {
            return 0;
        }   
            
        $taxPersent = 100 * $taxTotal / $subtotal;
        
        return $taxPersent;
    } // end _getTaxTotalPersent
    
    public function getRetailSubTotal()
    {
        $cart = WooCommerceCartFacade::getInstance();
        $products = $cart->getProducts();

        $total = 0;
        $displayMode = ($cart->isPricesIncludeTax()) ? true : false;

        foreach ($products as $key => $product) {
            if ($this->_isVariableProduct($product)) {
                $idProduct = $product['variation_id'];
            } else {
                $idProduct = $product['product_id'];
            }
            
            $productInstance = $this->engine->createProductInstance($idProduct);
            $price = $this->engine->products->getRegularPrice(
                $productInstance,
                $displayMode
            );
            
            $total += $price * $product['quantity'];
        }
        
        return $total;
    } // end getRetailSubTotal
    
    private function _isVariableProduct($product)
    {
        return array_key_exists('variation_id', $product)
               && !empty($product['variation_id']);
    } // end _isVariableProduct
    
    private function _isTaxExcludedFromPriceAndDisplaysSeparately($cart)
    {
        return (!$cart->isPricesIncludeTax() 
            && !$cart->isTaxInclusionOptionOn());
    } // end _isTaxExcludedFromPriceAndDisplaysSeparately
    
    private function _getUserPriceForSubscriptions($subscribeProduct)
    {
        $id = $this->engine->getProductID($subscribeProduct);
        $product = $this->engine->createProductInstance($id);
        
        $userPrice = $this->engine->products->getUserPrice($product, true);
        
        return $userPrice;
    } // _getUserPriceForSubscriptions
    
    private function _getShippingTotalWithTax()
    {
        $cart = WooCommerceCartFacade::getInstance();
        
        $shippingTotal = $cart->getShippingTotal();
        $shippingTaxTotal = $cart->getShippingTaxTotal();

        return $shippingTotal + $shippingTaxTotal;
    } // end _getShippingTotalWithTax
    
    private function _isRetailTotalMoreThanUserTotal($retailTotal, $userTotal)
    {
        return $retailTotal > $userTotal;
    } // end _isRetailTotalMoreThanUserTotal
    
    private function _getTotalSavings($retailTotal, $userTotal)
    {        
        $savings = round(100 - ($userTotal/$retailTotal * 100), 2);
        
        return $savings;
    } // end _getTotalSavings
    
    private function _fetchTotalSavings($totalSavings)
    {
        $vars = array(
            'discount' => $totalSavings
        );

        return $this->engine->fetch('discount.phtml', $vars);
    } // end _fetchTotalSavings
    
    private function _isSubscriptionInCart($cart)
    {   
        $products = $cart->getProducts();

        foreach ($products as $key => $value) {
            $product = $value['data'];
            
            if (!$this->_isSubcribePluginProducts($product)) {
                continue;
            }
            
            if ($this->_isSubscriptionRenewal($value)) {
                return false;
            }
            
            $this->engine->subscriptionKey = $key;

            return true;
        }
        
        return false;
    } // end _isSubscriptionInCart
    
    private function _isSubscriptionRenewal($subscription)
    {
        return !empty($subscription['subscription_renewal']);
    } // end _isSubscriptionRenewal
    
    public function setSubscriptionProductOption($cart)
    {
        $engine = &$this->engine;
        $products = $cart->getProducts();
        $product = $products[$engine->subscriptionKey];
        
        $engine->subscribeProduct = $product['data'];
        $engine->subscriptionCount = $this->_getSubscriptionProductsCount(
            $product
        );
       
        $engine->subscriptionTax = $this->_getSubscriptionTaxPersent($product);
        
        $coupons = $cart->getCoupons();
        
        $engine->subscriptionFee = $this->_getFee($product['data'], $coupons);
        
        $this->subscriptionPrice = $this->_getSubscriptionPriceWithTaxAndFee(
            $product
        );
    }
    
    private function _getSubscriptionProductsCount($product)
    {
        return $product['quantity'];
    } // end getSubscriptionProductsCount
    
    
    private function _getSubscriptionTaxPersent($product)
    {
        $total = $product['line_total'];
        $taxTotal = $product['line_tax'];
        
        $percent = $taxTotal / ($total / 100);

        return $percent;
    } // end _getSubscriptionTaxPersent
    
    private function _getTotalRetailWithoutSubscription($cart)
    {
        $products = $cart->getProducts();
        $total = 0;
        
        foreach ($products as $product) {
            if ($this->_isSubcribePluginProducts($product['data'])) {
                continue;
            }

            $price = $product['data']->price * $product['quantity'];
            $taxPersent = $this->_getSubscriptionTaxPersent($product);
            $tax = $price / 100 * $taxPersent;
            $total += $price + $tax;
        }
        
        return $total;
    } // end _getTotalRetailWithoutSubscription
    
    private function _getFee($subscription, $coupons = false)
    {
        $fee = false;
        
        if (!$this->_isFeeExist($subscription)) {
            return $fee;
        }
        
        $engine = &$this->engine;
        
        $fee = $subscription->subscription_sign_up_fee;
        
        if ($this->_isTaxExist()) {
            $discountCoupon = $this->_getCouponsDiscount($coupons);
            if ($discountCoupon) {
               $feeCupon = $fee - $fee * $discountCoupon / 100;
               $fee = $feeCupon + $feeCupon * $engine->subscriptionTax / 100; 
            } else {
                $feeTax = $fee * $engine->subscriptionTax / 100; 
                $fee = $fee + $feeTax;
            }
           
        }

        $fee = $fee * $engine->subscriptionCount;
        
        return $fee;
    } // end _getFee
    
    private function _isFeeExist($product) 
    {
        return !empty($product->subscription_sign_up_fee);
    } // end _isFeeExist
    
    private function _isTaxExist()
    {
        return $this->engine->taxPersent > 0;
    } // end _isTaxExist
    
    private function _isSubcribePluginProducts($product)
    {
        $types = array(
            'subscription_variation',
            'subscription',
            'variable-subscription'
        );
        
        $type = $this->ecommerceFacade->getProductType($product);
        
        return in_array($type, $types);
    } // end _isSubcribePluginProducts
    
    private function _getSubscriptionPriceWithTaxAndFee($product)
    {
        $fee = $this->engine->subscriptionFee;
        
        $price = $product['data']->subscription_price;
        
        $priceTax = ($price / 100) * $this->engine->subscriptionTax;
        
        return $fee + $price + $priceTax;
    } // end _getSubscriptionPriceWithTaxAndFee
    
    private function _hasSubscriptionFee()
    {
        return $this->engine->subscriptionFee;
    } // end _hasSubscriptionFee
    
    private function _isTrialSubscription($product)
    {
        return !empty($product->subscription_trial_length);
    } // end _isTrialSubscription
    
    private function _getCouponsDiscount($coupons)
    {
        $discounts = array();
        
        foreach ($coupons as $key => $item) {
            if ($item->discount_type == 'sign_up_fee_percent') {
                $discounts[] = $item->coupon_amount; 
            }
        }
        
        return count($discounts) > 0 ? max($discounts) : false;
    } // end _getCouponsDiscount
    
    private function _getShippingCost($cart)
    {
        $shippingMethods = WC()->session->get(
            'chosen_shipping_methods',
            array()
        );

        $shippingCost = $cart->getShippingCost($shippingMethods);
        
        return $shippingCost;
    } // end _getShippingCost
    
    private function _getRegularPriceForSubscription($subscribeProduct) 
    {
        $engine = &$this->engine;
        $id = $engine->getProductID($subscribeProduct);
        $product = $engine->createProductInstance($id);
        
        $regularPrice = $engine->products->getRegularPrice($product, true);

        return $regularPrice;
    } // end _getRegularPriceForSubscription
}
