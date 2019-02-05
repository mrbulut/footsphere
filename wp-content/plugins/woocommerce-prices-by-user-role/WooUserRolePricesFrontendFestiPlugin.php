<?php
require_once __DIR__."/common/autoload.php";

class WooUserRolePricesFrontendFestiPlugin extends WooUserRolePricesFestiPlugin
{
    const TYPE_PRODUCT_SIMPLE = 'simple';
    
    const TYPE_PRICE_USER = 'user';
    const TYPE_PRICE_REGULAR = 'regular';
    
    private $_ecommerceFacade;
    
    protected $settings = array();
    public $userRole;
    public $products;
    protected $eachProductId = 0;
    protected $removeLoopList = array();
    protected $textInsteadPrices;
    protected $mainProductOnPage = 0;
    private $_listOfProductsWithRolePrice = array();
    
    public $subscriptionTax;
    public $subscriptionCount;
    public $subscribeProduct;
    public $subscriptionFee;
    public $subscriptionKey;
    protected $subscriptionPrice;
    public $mainTotals;
    protected $ecommerceFacade;
    
    private static $_settings = array();
    private static $_filterPrices = array();
    private static $_rangePrices = array();
    private static $_isSalePrices = array();

    protected function onInit()
    {
        WooUserRoleModule::init($this);
        
        $systemModule = WooUserRoleModule::get('System'); 
        if (!$systemModule->isSesionStarted()) {
            session_start();
        }
        
        if ($systemModule->isMaxExecutionTimeLowerThanConstant()) {
            ini_set(
                'max_execution_time',
                WooUserRolePricesFestiPlugin::MAX_EXECUTION_TIME
            );
        }

        $this->addActionListener('woocommerce_init', 'onInitFiltersAction');

        $this->addActionListener('wp', 'onHiddenAndRemoveAction');

        $this->addActionListener('wp_print_styles', 'onInitCssAction');
        $this->addActionListener('wp_enqueue_scripts', 'onInitJsAction');

        $this->addFilterListener(
            'woocommerce_get_variation_prices_hash',
            'onAppendDataToVariationPriceHashGeneratorFilter',
            10,
            3
        );
        
        $this->_onInitApi();
        
        $this->_ecommerceFacade = EcommerceFactory::getInstance();
    } // end onInit
    
    public function getSettings()
    {
        if (static::$_settings) {
            $this->settings = static::$_settings;
            return static::$_settings;
        }
        
        static::$_settings = $this->getOptions('settings');
        $this->settings = static::$_settings;

        if (!$this->settings) {
            throw new Exception('The settings can not be empty.');
        }

        return $this->settings;
    } // end getSettings
         
    private function _onInitApi()
    {
        $apiFacade = new WooUserRolePricesApiFacade($this);
        $apiFacade->init();
    } // end _onInitApi
    
    public function onAppendDataToVariationPriceHashGeneratorFilter(
        $productData, $product, $display
    )
    {
        $roles = $this->getAllUserRoles();
        
        $value = PRICE_BY_ROLE_HASH_GENERATOR_VALUE_FOR_UNREGISTRED_USER;
        $data = (!$roles) ? array($value) : $roles;

        $productData[PRICE_BY_ROLE_HASH_GENERATOR_KEY] = $data;
        
        return $productData;
    } // end onAppendDataToVariationPriceHashGeneratorFilter
    
    protected function getProductsInstances()
    {
        return new FestiWooCommerceProduct($this);
    } // end getProductsInstances
    
    public function onGetTextInsteadOfEmptyPrice()
    {
        return WooUserRoleModule::get('EmptyPrice')
            ->onGetTextInsteadOfEmptyPrice();
    } // end onGetTextInsteadOfEmptyPrice
    
    public function onInitFiltersAction()
    {        
        $this->userRole = $this->getUserRole();
        
        $this->products = $this->getProductsInstances();
        
        $this->addActionListener('wp', 'onInitMainActionByProductID');
        
        if ($this->hasDiscountOrMarkUpForUserRoleInGeneralOptions()) {
            $this->onFilterPriceByDiscountOrMarkup();   
        } else {
            $this->onFilterPriceByRolePrice();
        }

        $this->onDisplayCustomerSavings();

        $this->onFilterPriceRanges();
    } // end onInitFiltersAction
    
    public function onHiddenAndRemoveAction()
    {
       //$this->onHideAddToCartButton();
        WooUserRoleModule::get('HidePrice')->onHideAddToCartButton();
        //$this->onHidePrice();
       WooUserRoleModule::get('HidePrice')->onHidePrice();
        
       WooUserRoleModule::get('EmptyPrice')->onHideEmptyPrice();
    } // end onHiddenAndRemoveAction
    
    public function onInitMainActionByProductID()
    {
        $this->getMainProductID();
    } // end onInitMainActionByProductID
    
    protected function onFilterPriceRanges()
    {
        $hookManager = new WooUserRolePricesFrontendHookManager($this);
        
        $hookManager->onInit();
    } // end onFilterPriceRanges
    
    public function onShowVariationPriceForCustomerSavings($isShow)
    {
        return WooUserRoleModule::get('PriceSavings')
            ->onShowVariationPriceForCustomerSavings($isShow);
    } // end onShowVariationPriceForCustomerSavings
    
    public function onRemovePriceForUnregisteredUsers($price, $product)
    {
        return WooUserRoleModule::get('HidePrice')
            ->onRemovePriceForUnregisteredUsers($price, $product);
    }
    
    public function onSalePriceCheck($isSale, $product)
    {
        $id = $this->_ecommerceFacade->getProductID($product);
        
        if (array_key_exists($id, static::$_isSalePrices)) {
            return static::$_isSalePrices[$id];
        }

        $isSalePrice = $this->_isSalePriceCheck($isSale, $product);
        
        static::$_isSalePrices[$id] = $isSalePrice;
        
        return $isSalePrice;
    }
    
    private function _isSalePriceCheck($isSale, $product)
    {
        $id = $this->_ecommerceFacade->getProductID($product);
        
        if ($this->_hasSalePriceByUnregisteredUser($product)) {
            return true;
        }
        
        if ($this->_hasSalePriceForUserRole($product)) {
            return $this->_isRoleSalePriceLowerThenRolePrice($product);
        }
        
        if ($this->_hasRolePriceBySimpleProduct($product)) {
            return false;
        }
        
        if ($this->hasRoleSalePriceByVariableProduct($product)) {
            return true;
        }
        
        return $isSale;
    }
    
    private function _hasSalePriceByDiscountOrMarkUpProduct($product)
    {
        return $this->_isEnableBothRegularSalePriceSetting() && 
               $this->_hasSalePrice($product);
    }
    
    private function _hasSalePriceByUnregisteredUser($product)
    {
        if (!$this->_isSimpleTypeProduct($product)) {
            return false;
        }
        
        if ($this->isRegisteredUser()) {
            return false;
        }
        
        return (bool) $product->get_sale_price();
    }
    
    public function onHideSelectorSaleForProduct($content, $post, $product)
    {
        if ($this->hasRoleSalePriceByVariableProduct($product)) {
            return $content;
        }
        
        if ($this->_isEnableBothRegularSalePriceSetting()) {
            return $content;
        }
        if ($this->_hasRolePriceByVariableProduct($product)) {
            return false;
        }
        
        if ($this->_hasRolePriceBySimpleProduct($product)) {
            return false;
        }
        
        if ($this->isDiscountOrMarkupEnabledByRole($this->userRole)) {
            if ($this->_hasSalePriceByDiscountOrMarkUpProduct($product)) {
                return $content;
            }
            return false;
        }
        
        return $content;
    }
    
    private function _hasRolePriceBySimpleProduct($product)
    {
        if (!$this->_isSimpleTypeProduct($product)) {
            return false;
        }
        $idProduct = $this->_ecommerceFacade->getProductID($product);
        $prices = $this->getProductPrices($idProduct);

        if ($this->_hasSalePriceByUserRole($prices)) {
            return false;
        }
        
        if ($this->_hasPriceByUserRole($prices)) {
            return true;
        }
       
        return false;
    }
    
    private function _hasSalePriceByUserRole($prices)
    {
        return $this->userRole
               && array_key_exists('salePrice', $prices)
               && array_key_exists($this->userRole, $prices['salePrice'])
               && $prices['salePrice'][$this->userRole];
    }
    
    
    private function _isSimpleTypeProduct($product)
    {
        $facade = &$this->_ecommerceFacade;
        return $facade->getProductType($product) == static::TYPE_PRODUCT_SIMPLE;
    }
    
    private function _hasRolePriceByVariableProduct($product)
    {
        if (!$this->isVariableTypeProduct($product)) {
            return false;
        }
        $productsIDs = $product->get_children();
        $flag = false;
        
        if ($productsIDs) {
            foreach ($productsIDs as $id) {
                $prices = $this->getProductPrices($id);
                
                if ($this->_hasPriceByUserRole($prices)) {
                    $flag = true;
                    break;
                }
            }
        }
        
        return $flag;
    }
    
    private function _hasPriceByUserRole($prices)
    {
        return $this->userRole
               && array_key_exists($this->userRole, $prices)
               && $prices[$this->userRole];
    }

    public function onPriceFilterWidgetResults($products, $min, $max)
    {
        if (!$this->userRole) {
            return $products;
        }
        
        $rolePrices = $this->getRolePricesForWidgetFilter();
        
        $productIDs = array();
        foreach ($rolePrices as $productId => $price) {
            if ($this->_isRolePriceBetweenMinMax($price, $min, $max)) {
                $productIDs[] = $productId;
            }
        }
        
        $products = $this->_ecommerceFacade->getProductsByIDsForWidgetFilter(
            $productIDs
        );
       
        $products = $this->_getPrepareProductsByFilter($products);
            
        return $products;
    }
    
    private function _isRolePriceBetweenMinMax($rolePrice, $min, $max)
    {
        return $rolePrice && $rolePrice <= $max && $rolePrice >= $min;
    }
    
    private function _getPrepareProductsByFilter($products)
    {
        foreach ($products as $key => $product) {
            $products[$key] = (object) $product;
        }
        return $products;
    }
    
    public function onPriceFilterWidgetMaxAmount($max)
    {
        if ($this->userRole) {
            $resultPrices = $this->getRolePricesForWidgetFilter();
            
            if ($resultPrices) {
                return max($resultPrices);
            }            
        }     
        return $max;
    }
    
    public function onPriceFilterWidgetMinAmount($min)
    {
        if ($this->userRole) {
            $resultPrices = $this->getRolePricesForWidgetFilter();
            if ($resultPrices) {
                return min($resultPrices);
            }
        }    
        return $min;
    }
   

    public function getRolePricesForWidgetFilter()
    {
        $facade = &$this->_ecommerceFacade;
        $productsIDs = $facade->getProductsIDsForRangeWidgetFilter();
        
        $rolePrices = array();
        
        foreach ($productsIDs as $id) {

            $product = $this->createProductInstance($id);

            if (!$this->hasProductID($product)) {
                continue;
            }
            
            $rolePrices[$id] = $this->products->getUserPrice($product);
        }
        
        $rolePrices = $this->_getPrepareRolePrices($rolePrices);
        
        return $rolePrices;
    }
    
    public function hasProductID($product)
    {
        return (bool) $this->_ecommerceFacade->getProductID($product);
    }
    

    private function _getPrepareRolePrices($rolePrices)
    {
        
        foreach ($rolePrices as $key => $item) {
            if (!$item) {
                unset($rolePrices[$key]);    
            }
        }
        
        return $rolePrices;
    }
    
    public function onHideProductByUserRole($query)
    {
        return WooUserRoleModule::get('HideProduct')
            ->onHideProductByUserRole($query);
    }

    public function onProductPriceOnlyRegisteredUsers($price)
    {
        return WooUserRoleModule::get('HidePrice')
            ->onProductPriceOnlyRegisteredUsers($price);
    } // end onProductPriceOnlyRegisteredUsers
    
    public function getTextInsteadPrices()
    {
        return $this->textInsteadPrices;   
    } // end getTextInsteadPrices
    
    public function setTextInsteadPrices($content)
    {
        return $this->textInsteadPrices = $content;   
    } // end setTextInsteadPrices
    
    public function onSalePriceToNewPriceTemplateFilter(
        $price, $sale, $newPrice, $product
    )
    {
        if (!$this->isRegisteredUser()) {
            return $price;
        }
        $idProduct = $this->_ecommerceFacade->getProductID($product);
        $prices = $this->getProductPrices($idProduct);
        
        if (!$this->_hasPriceByUserRole($prices)) {
            return $price;
        }
        
        $product = $this->getProductNewInstance($product);
        
        if (!$this->products->isAvaliableToDisplaySaleRange($product)) {
        
            $price = $this->products->getFormatedPriceForSaleRange(
                $product,
                $newPrice
            );
            
            $price = $this->getFormattedPrice($price);
        }
        
        return $price;
    } // end onSalePriceToNewPriceTemplateFilter
    
    private function _fetchRolePriceRangeByVariableProduct($prices)
    {
        if (!$prices) {
            return false;
        }
        
        $minPrice = $this->getFormattedPrice(min($prices));
        $maxPrice = $this->getFormattedPrice(max($prices));
        
        return $this->fetchProductPriceRange($minPrice, $maxPrice);
    } // _fetchRolePriceRangeByVariableProduct
    
    public function onProductPriceRangeFilter($price, $product)
    {
        $id = $this->_ecommerceFacade->getProductID($product);
        if (!empty(static::$_rangePrices[$id])) {
            return static::$_rangePrices[$id];
        }
        
        $price = $this->_getProductPriceRangeFilter($price, $product);
        
        static::$_rangePrices[$id] = $price;
        
        return $price;
        
    } // end onProductPriceRangeFilter
    
    private function _fetchRolePriceByVariableProduct($product)
    {
        $regularPrices = $this->getRolePricesVariableProductByPriceType(
            $product,
            PRICE_BY_ROLE_TYPE_PRODUCT_REGULAR_PRICE
        ); 
        
        $salePrices = $this->getRolePricesVariableProductByPriceType(
            $product,
            PRICE_BY_ROLE_TYPE_PRODUCT_SALE_PRICE
        );

        if (empty($salePrices)) {
            return $this->_fetchRegularPriceRangeForVariableProduct(
                $product,
                $regularPrices
            );
        }
        
        $isDifferentAmount = $this->_hasDifferentAmountOfPriceInProduct(
            $regularPrices,
            $salePrices
        );
        if ($isDifferentAmount) {
            $prices = $this->_ecommerceFacade->getPricesFromVariationProduct(
                $product
            );
            return $this->_fetchRolePriceRangeByVariableProduct($prices);
        }
        
        return $this->_fetchSalePriceRangeForVariableProduct(
            $product,
            $regularPrices,
            $salePrices
        );
    } // end _fetchRolePriceByVariableProduct
    
    private function _hasDifferentAmountOfPriceInProduct(
        $regularPrices, $salePrices
    )
    {
         return count($regularPrices) != count($salePrices);
    } // end _hasDifferentAmountOfPriceInProduct
    
    private function _fetchRegularPriceRangeForVariableProduct(
        $product,
        $prices
    )
    {
        $price = $this->_fetchRolePriceRangeByVariableProduct(
            $prices
        );
        $priceSuffux = $this->_ecommerceFacade->getPriceSuffix($product);
        $vars = array(
            'regularPrice' => $price.$priceSuffux,
        );

        return $this->fetch('price_role_with_sale_variable.phtml', $vars);
    } // end _fetchRegularPriceRangeForVariableProduct
    
    private function _fetchSalePriceRangeForVariableProduct(
        $product,
        $regularPrices,
        $salePrices
    )
    {
        $regularPrice = $this->_fetchRolePriceRangeByVariableProduct(
            $regularPrices
        );

        $salePrice = $this->_fetchRolePriceRangeByVariableProduct(
            $salePrices
        );
        
        $suffix = $this->_ecommerceFacade->getPriceSuffix($product);

        $vars = array(
            'regularPrice' => $regularPrice,
            'salePrice'    => $salePrice.$suffix
        );
        
        return $this->fetch('price_role_with_sale_variable.phtml', $vars);
    } // end _fetchSalePriceRangeForVariableProduct
    
    public function fetchProductPriceRangeFilter($price, $product)
    {
        $product = $this->getProductNewInstance($product);
            
        $priceRangeType = PRICE_BY_ROLE_MIN_PRICE_RANGE_TYPE;
        
        $from = $this->getPriceByRangeType(
            $product,
            $priceRangeType,
            true
        );
        
        $priceRangeType = PRICE_BY_ROLE_MAX_PRICE_RANGE_TYPE;
        $to = $this->getPriceByRangeType(
            $product,
            $priceRangeType,
            true
        );
        
        if (!$from && !$to) {
            return $price;
        }
        
        $from = $this->getFormattedPrice($from);
        $to = $this->getFormattedPrice($to);
        
        $displayPrice = $this->fetchProductPriceRange($from, $to);
        
        $priceSuffix = $this->_ecommerceFacade->getPriceSuffix($product);
        $price = $displayPrice.$priceSuffix;
        
        return $price;
    } // fetchProductPriceRangeFilter
    
    private function _getProductPriceRangeFilter($price, $product)
    {
        if ($this->_hasNewPriceForVariableProduct($product)) {
            return $price;
        }
        
        if ($this->hasDiscountOrMarkUpForUserRoleInGeneralOptions()) {
            return $this->fetchProductPriceRangeFilter($price, $product);
        }
        
        return $this->_fetchRolePriceByVariableProduct($product);
    } // end onProductPriceRangeFilter
        
    private function _hasNewPriceForVariableProduct($product)
    {
        return !$this->_hasRolePriceByVariableProduct($product) 
               && !$this->hasDiscountOrMarkUpForUserRoleInGeneralOptions();
    }
        
    public function isVariableTypeProduct($product)
    {
        return $this->_ecommerceFacade->getProductType($product) == 'variable';
    }
    
    protected function fetchProductPriceRange($from, $to)
    {
        if ($from == $to) {
            $template = '%1$s';
        } else {
            $template = '%1$s&ndash;%2$s';
        }
        
        $content = _x($template, 'Price range: from-to', 'woocommerce');
        
        $content = sprintf($content, $from, $to);
        
        return $content;
    } // end fetchProductPriceRange
    
    public function getMainProductID()
    {
        if ($this->mainProductOnPage) {
            return $this->mainProductOnPage;
        }
        
        if (!$this->isProductPage()) {
            return false;
        }
        
        $this->mainProductOnPage = get_the_ID();
        
        return $this->mainProductOnPage;
    } //end getMainProductID
    
    protected function onDisplayCustomerSavings()
    {
        if ($this->_isMarkupEnabledOrDiscountFromRolePrice()) {
            return false;
        }
        
        $this->products->onDisplayCustomerSavings();
        
        $this->mainTotals = true;
        
        $this->addFilterListener(
            'woocommerce_cart_totals_order_total_html',
            'onDisplayCustomerTotalSavingsFilter',
            10,
            2
        );
        
        $this->addFilterListener(
            'wcs_cart_totals_order_total_html',
            'onDisplayCustomerTotalSavingsFilter',
            10,
            2
        );
    } // end onDisplayCustomerSavings 
    
    private function _isMarkupEnabledOrDiscountFromRolePrice()
    {
        return !$this->_isDiscountTypeEnabled()
               && $this->_isRolePriceDiscountTypeEnabled();
    } // end _isMarkupEnabledOrDiscountFromRolePrice

    public function getUserTotalWithSubscription($total)
    {
        return WooUserRoleModule::get('PriceSavings')
            ->getUserTotalWithSubscription($total);
    }
    
    public function isOnlySubscriptionInCart($cart)
    {
        $products = $cart->getProducts();
        
        return count($products) == 1;
    }
    
    public function getProductID($product)
    {
        $facade = &$this->_ecommerceFacade;
        if ($this->isSubscribeVariableProduct($product)) {
            $idProduct = $facade->getVariationProductID($product);
        } else {
            $idProduct = $facade->getProductID($product);
        }
        
        return $idProduct;
    }
    
    public function isSubscribeVariableProduct($product) 
    {
        return (bool) $this->_ecommerceFacade->getVariationProductID($product);
    }

    public function getTotalRetailWithSubscription($total, $cart)
    {
        return WooUserRoleModule::get('PriceSavings')
            ->getTotalRetailWithSubscription($total, $cart);
    }

    public function setSubscriptionProductOption($cart)
    {
        return WooUserRoleModule::get('PriceSavings')
            ->setSubscriptionProductOption($cart);
    }
    
    public function onDisplayCustomerTotalSavingsFilter($total)
    {
        return WooUserRoleModule::get('PriceSavings')
            ->onDisplayCustomerTotalSavingsFilter($total);
    } // end onDisplayCustomerTotalSavingsFilter    

    protected function getRetailTotal()
    {
        return WooUserRoleModule::get('PriceSavings')->getRetailTotal();
    } // end getRetailTotal

    protected function getRetailSubTotalWithTax()
    {
        return WooUserRoleModule::get('PriceSavings')
            ->getRetailSubTotalWithTax();
    } // end getRetailSubTotalWithTax
    
    public function onVariationPriceFilter(
        $price, $product, $priceRangeType, $display
    )
    {
        $product = $this->getProductNewInstance($product);
               
        $userPrice = $this->getPriceByRangeType(
            $product,
            $priceRangeType,
            $display
        );
        
        if ($userPrice) {
            $price = $this->getPriceWithFixedFloat($userPrice);
        }

        return $price;
    } // end onVariationPriceFilter
    
    public function getPriceByRangeType($product, $rangeType, $display)
    {
        if ($this->_isMaxPriceRangeType($rangeType)) {
            $price = $this->products->getMaxProductPice($product, $display);
        } else {
            $price = $this->products->getMinProductPice($product, $display);
        }
        
        return $price;
    } // end getPriceByRangeType
    
    private function _isMaxPriceRangeType($rangeType)
    {
        return $rangeType == PRICE_BY_ROLE_MAX_PRICE_RANGE_TYPE;
    } // end _isMaxPriceRangeType
        
    public function fetchPrice(
        $price, $type = WooUserRolePricesFrontendFestiPlugin::TYPE_PRICE_REGULAR
    )
    {
        $vars = array(
            'price' => $price,
            'type'  => $type
        );
        
        return $this->fetch('price.phtml', $vars);
    } // end fetchRegularPrice
    
    private function _isRoleSalePriceLowerThenRolePrice($product)
    {
        return $this->getSalePrice($product) < $this->getPrice($product);
    }

    /**
     * Display price HTML for all product type like simplae and variable.
     * 
     * @param string $price html content for display price
     * @param WC_Product $product
     * @return string
     */

    public function onDisplayCustomerSavingsFilter(
        $price, $product
    )
    {
        if ($this->_isOneHundredPercentDiscountEnabled()) {
            return $this->fetch('free.phtml');
        }
        
        if (
            $this->_hasRolePriceByVariableProduct($product) ||
            $this->isVariableTypeProduct($product)
        ) {
            if ($this->_isEnableBothRegularSalePriceSetting()) {
                return $this->fetchVariableBothRegularSalePrice(
                    $price,
                    $product
                );
            }
            return $price;
        }

        $product = $this->getProductNewInstance($product);

        $result = WooUserRoleModule::get('PriceSavings')
            ->hasConditionsForDisplayCustomerSavingsInProduct($product);
    
        if (!$result) {      
                  
            if (
                $this->_isDisplayDefaultPriceForCustomerSavingsFilter($product)
            ) {
                return $this->fetchUserRolePrice($product);
            }

            if (
                $this->_hasSalePriceForUserRole($product) && 
                $this->_isRoleSalePriceLowerThenRolePrice($product)
            ) {
                $content = $this->_fetchPriceAndSalePriceForUserRole(
                    $product
                );
                return $content;
            }
            
            return $this->_fetchSimpleBothRegularSalePrice($product, $price);
        }
        
        return WooUserRoleModule::get('PriceSavings')
            ->onDisplayCustomerSavingsFilter($product);
        
    } // end onDisplayPriceContentForSingleProductFilter
    
    private function _isDisplayVariableRegularPrice($product, $salePrices)
    {
        $min = min($salePrices);
        $max = max($salePrices);
        $productsIDs = $product->get_children();
        
        return $min == $max && sizeof($productsIDs) == sizeof($salePrices);
    } // end _isDisplayVariableRegularPrice

    
    public function fetchVariableBothRegularSalePrice($price, $product)
    {
        $wooFacade = &$this->_ecommerceFacade;
        
        $productsIDs = $wooFacade->getVariationChildrenID($product);
        
        $regularPrices = array();
        $salePrices = array();
        foreach ($productsIDs as $id) {
            $productChild = $this->createProductInstance($id);

            $regularPrices[] = $this->getPriceWithDiscountOrMarkUp(
                $productChild,
                $wooFacade->getRegularPrice($productChild),
                false
            );
            
            if ($wooFacade->getSalePrice($productChild)) {
                $salePrices[] = $wooFacade->getSalePrice($productChild);
            }
        }
        
        $regularPriceContent = false;
        if ($this->_isDisplayVariableRegularPrice($product, $salePrices)) {
            $regularPriceContent = $this->_fetchRolePriceRangeByVariableProduct(
                $regularPrices
            );
        }
        
        $vars = array(
            'price' => $regularPriceContent,
            'salePrice' => $price
        );
        
        $content = $this->fetch(
            'price_role_width_sale.phtml',
            $vars
        );
        
        return $content;
    } // end fetchVariableBothRegularSalePrice
    
    private function _isEnableBothRegularSalePriceSetting()
    {
        $settings = $this->getSettings();
        return array_key_exists('bothRegularSalePrice', $settings) && 
               $settings['bothRegularSalePrice']
               && $this->hasDiscountOrMarkUpForUserRoleInGeneralOptions();
    }
    
    private function _hasSalePrice($product)
    {
        return (bool) $this->_ecommerceFacade->getSalePrice($product);
    }
    
    private function _fetchSimpleBothRegularSalePrice($product, $price)
    {
        if (!$this->hasDiscountOrMarkUpForUserRoleInGeneralOptions()) {
            return $price;
        }
        
        $wooFacade = &$this->_ecommerceFacade;
        
        $originalRegularPrice = $wooFacade->getRegularPrice($product);
        
        $regularPrice = $this->getPriceWithDiscountOrMarkUp(
            $product,
            $originalRegularPrice,
            false
        );
        
        $originalSalePrice = $wooFacade->getSalePrice($product);
        
        $salePrice =  $this->getPriceWithDiscountOrMarkUp(
            $product,
            $originalSalePrice
        );
        
        if ($this->_isOnePriceByVariableProduct($product)) {
            return false;
        }
        
        if ($regularPrice == 0 && $salePrice == 0) {
            return $this->fetch('free.phtml');
        }
        
        $vars['salePrice'] = $this->getFormattedPrice($salePrice);
        
        if ($this->_isDifferentPrices($regularPrice, $salePrice)) {
            $vars['price'] = $this->getFormattedPrice($regularPrice);
        }
        
        if (!$salePrice) {
            $vars['salePrice'] = $this->getFormattedPrice($regularPrice);
        }
        
        $content = $this->fetch(
            'price_role_width_sale.phtml',
            $vars
        );

        return $content;
    }
    
    private function _isDifferentPrices($regularPrice, $salePrice)
    {
        return $salePrice && $regularPrice != $salePrice;
    }
    
    private function _isOnePriceByVariableProduct($product)
    {
        if ($this->_isEnableBothRegularSalePriceSetting()) {
            return false;
        }
        
        $regularPrices = $this->_getVariableRegularPrices($product);
            
        return sizeof(array_unique($regularPrices)) == 1;
    }
    
    private function _getVariableRegularPrices($product)
    {
        $regularPrices = array();
        
        if (!$this->isProductParentMainproduct($product)) {
            return $regularPrices;
        }
        $wooFacade = &$this->_ecommerceFacade;
        
        $parentID = $wooFacade->getProductParentID($product);
        $product = $this->createProductInstance($parentID);
        
        $productsIDs = $wooFacade->getVariationChildrenID($product);
        foreach ($productsIDs as $id) {
            $productChild = $this->createProductInstance($id);
            $regularPrices[] = $wooFacade->getRegularPrice($productChild);
        }
        
        return $regularPrices;
    }

    private function _isOneHundredPercentDiscountEnabled()
    {
        if ($this->isRegisteredUser()) {
            return $this->getAmountOfDiscountOrMarkUp() >= 100 &&
                   $this->_isPercentDiscountType() &&
                   $this->_isDiscountTypeEnabled();
        }
        return false;
    } // end _isOneHundredPercentDiscountEnabled

    private function _isDisplayDefaultPriceForCustomerSavingsFilter($product)
    {
        $productPrice = $this->getPrice($product);
        
        $emptyPriceSymbol = $this->_ecommerceFacade->getEmptyPriceSymbol();
        
        return $productPrice && !$this->_isDefaultCurrencyActive() &&
               $this->isRegisteredUser() &&
               $productPrice !== $emptyPriceSymbol;
    } // end _isDisplayDefaultPriceForCustomerSavingsFilter
    
    
    private function _hasSalePriceForUserRole($product)
    {
        if (!$this->isVariableTypeProduct($product)) {
            $salePrice = $this->getSalePrice($product);
            
            return (bool) $salePrice;
        }
    }

    private function _isDefaultCurrencyActive()
    {
        $defaultCurrency = WooCommerceFacade::getDefaultCurrencyCode();
        $activeCurrency = WooCommerceFacade::getBaseCurrencyCode();

        return $defaultCurrency == $activeCurrency;
    } // end _isDefaultCurrencyActive
    
    private function _fetchUserRolePrice($product)
    {
        $price = $this->getPrice($product);
        
        $formatPrice = $this->getFormattedPrice($price);
        $typePriceUser = WooUserRolePricesFrontendFestiPlugin::TYPE_PRICE_USER;
        return $this->fetchPrice($formatPrice, $typePriceUser);
    } // end _fetchUserRolePrice
    
    private function _fetchPriceAndSalePriceForUserRole($product)
    {
        $price = $this->getPrice($product);
        $salePrice = $this->getSalePrice($product);
        
        $vars = array(
            'price' => $this->getFormattedPrice($price),
            'salePrice' => $this->getFormattedPrice($salePrice)
        );
        
        $content = $this->fetch(
            'price_role_width_sale.phtml',
            $vars
        );
        
        return $content;
    } // end _fetchPriceAndSalePriceForUserRole
    
    public function getFormattedPrice($price)
    {
        return wc_price($price);
    } // end getFormattedPrice
        
    public function isProductParentMainproduct($product)
    {
        $idParent = $this->_ecommerceFacade->getProductParentID($product);
        if (!$idParent) {
            return false;
        }
        
        return $idParent == $this->mainProductOnPage;
    } // end isProductParentMainproduct
    
    public function getMainProductOnPage()
    {
        return $this->mainProductOnPage;
    }
     
    public function removeFilter($hook, $methodName, $priority = 10)
    {
        if (!is_array($methodName)) {
            $methodName = array(&$this, $methodName);
        }
        remove_filter($hook, $methodName, $priority);
    } // end removeFilter
    
    protected function onFilterPriceByRolePrice()
    {
        $this->products->onFilterPriceByRolePrice();
    } // end onFilterPriceByRolePrice
    
    public function onDisplayPriceByRolePriceFilter($price, $product)
    {
        $id = $this->_ecommerceFacade->getProductID($product);
        
        if (!empty(static::$_filterPrices[$id])) {
            return static::$_filterPrices[$id];
        }
        
        $price = $this->_getPriceByRolePriceFilter($price, $product);
        
        static::$_filterPrices[$id] = $price;
        
        return $price;
    } // end onDisplayPriceByRolePriceFilter
    
    private function _getPriceByRolePriceFilter($price, $product)
    {
        $product = $this->getProductNewInstance($product);

        if (!$this->isRegisteredUser()) {
            return $price;
        }
        
        $this->userPrice = $price;

        if (!$this->_hasUserRoleInActivePLuginRoles()) {
            return $this->getPriceWithFixedFloat($this->userPrice);
        }
       
        $newPrice = $this->getRolePriceOrSale($product);

        if ($newPrice) {
            $idProduct = $this->products->getProductId($product);
            $this->addIdToListOfPruductsWithRolePrice($idProduct);
            $this->userPrice = $newPrice;
            return $this->getPriceWithFixedFloat($this->userPrice);
        }
        
        $ecommFacade = &$this->_ecommerceFacade;
        
        if (
            $this->isVariableTypeProduct($product) &&
            $ecommFacade->isEnabledTaxCalculation() &&
            $ecommFacade->hasPriceDisplaySuffixPriceIncludingOrExcludingTax()
        ) {
            $priceFacade = UserRolePriceFacade::getInstance();

            return $priceFacade->getRolePriceForWoocommercePriceSuffix(
                $product,
                $this->userRole,
                $this,
                $ecommFacade
            );
        }
        
        $emptyPriceModule = WooUserRoleModule::get('EmptyPrice');
        if ($emptyPriceModule->isDisplayTextInsteadOfPriceEnabled()) {
            return $this->_ecommerceFacade->getEmptyPriceSymbol();
        }

        return $this->userPrice;
    } // end onDisplayPriceByRolePriceFilter
    
    protected function onFilterPriceByDiscountOrMarkup()
    {
        $this->products->onFilterPriceByDiscountOrMarkup();
    } // end onFilterPriceByDiscountOrMarkup
    
    public function onDisplayPriceByDiscountOrMarkupFilter($price, $product)
    {
        $product = $this->getProductNewInstance($product);
        
        if (!$this->isRegisteredUser()) {
            return $price;
        }

        $this->userPrice = $price;
        
        $newPrice = $this->getPriceWithDiscountOrMarkUp($product, $price);
        
        $idProduct = $this->products->getProductId($product);
        $this->addIdToListOfPruductsWithRolePrice($idProduct);
        $this->userPrice = $this->getPriceWithFixedFloat($newPrice);
       
        return $this->userPrice;
    } // end onDisplayPriceByDiscountOrMarkupFilter
    
    protected function addIdToListOfPruductsWithRolePrice($idProduct)
    {
        if (in_array($idProduct, $this->_listOfProductsWithRolePrice)) {
            return false;
        }
        
        $this->_listOfProductsWithRolePrice[] = $idProduct;
    } // end addIdToListOfPruductsWithRolePrice
    
    public function getListOfPruductsWithRolePrice()
    {
        return $this->_listOfProductsWithRolePrice;
    } // end getListOfPruductsWithRolePrice
    
    private function _hasUserRoleInActivePLuginRoles()
    {
        $roles = $this->getAllUserRoles();
        
        if (!$roles) {
            return false;
        }
        
        $activeRoles = $this->getActiveRoles();

        if (!$activeRoles) {
            return false;
        }
        
        
        $result =  $this->_hasOneOfUserRolesInActivePLuginRoles(
            $activeRoles,
            $roles
        );
        
        return $result;
    } // end _hasUserRoleInActivePLuginRoles
    
    private function _hasOneOfUserRolesInActivePLuginRoles($activeRoles, $roles)
    {
        $result = false;

        foreach ($roles as $key => $role) {
            $result = array_key_exists($role, $activeRoles);
            
            if ($result) {
                return $result;
            }
        }
    } // end _hasOneOfUserRolesInActivePLuginRoles
    
    /**
     * Returns price for product. 
     * @param WC_Product $product
     * @param float $originalPrice
     */

    public function getPriceWithDiscountOrMarkUp(
        $product, $originalPrice, $isSalePrice = true
    )
    {
        //FIXME: Need Refactoring
        
        $amount = $this->getAmountOfDiscountOrMarkUp();
       
        $idPost = $this->_ecommerceFacade->getProductID($product);
        
        
        if ($this->_ecommerceFacade->getVariationProductID($product)) {
            $idPost = $this->_ecommerceFacade->getVariationProductID($product);
        }
        
        if ($this->isIgnoreDiscountForProduct($idPost)) {
            $rolePrice = $this->getRolePrice($idPost);
            return $rolePrice ? $rolePrice : $originalPrice;
        }
       
        $isNotRoleDiscountType = false;
        $price = PRICE_BY_ROLE_PRODUCT_MINIMAL_PRICE;
        
        if ($this->_isRolePriceDiscountTypeEnabled()) {
            $price = $this->getPrice($product);
            
            if (!$price) {
                $isNotRoleDiscountType = true;
            }
        }

        if (!$price) {
            $price = $this->products->getRegularPrice($product);
            
            if ($isSalePrice && $this->_isAllowSalePrices($product)) {
                $price = $this->_ecommerceFacade->getSalePrice($product);
                static::$_isSalePrices[$idPost] = true;
            }
        }
        
        if ($isNotRoleDiscountType) {
            return $price;
        }
        
        if ($this->_isPercentDiscountType()) {
            $amount = $this->getAmountOfDiscountOrMarkUpInPercentage(
                $price,
                $amount
            );
        }

        if ($this->_isDiscountTypeEnabled()) {
            $minimalPrice = PRICE_BY_ROLE_PRODUCT_MINIMAL_PRICE;
            $newPrice = ($amount > $price) ? $minimalPrice : $price - $amount;
        } else {
            $newPrice = $price + $amount;
        }
        
        $numberOfDecimals = $this->_ecommerceFacade->getNumberOfDecimals();
        
        if (!$numberOfDecimals) {
            $newPrice = round($newPrice);
        }

        return $newPrice;
    } // end getPriceWithDiscountOrMarkUp
    
    private function _isAllowSalePrices($product)
    {
        return $this->_isEnableBothRegularSalePriceSetting() && 
               $this->_hasSalePrice($product);
    }
    
    public function getAmountOfDiscountOrMarkUpInPercentage($price, $discount)
    {
        $discount = $price / 100 * $discount;
        
        return $discount;
    } // end getAmountOfDiscountOrMarkUpInPercentage
    
    private function _isDiscountTypeEnabled()
    {
        $settings = $this->getSettings();
        return $settings['discountOrMakeUp'] == 'discount';
    } // end _isDiscountTypeEnabled
    
    private function _isPercentDiscountType()
    {
        $settings = $this->getSettings();
        
        if (!$this->_hasOptionByDiscountRoles('type', $settings)) {
            return false;
        }
        
        $discountType = $settings['discountByRoles'][$this->userRole]['type'];
        return $discountType == PRICE_BY_ROLE_PERCENT_DISCOUNT_TYPE;
    } // end _isPercentDiscountType
    
    private function _hasOptionByDiscountRoles($option, $settings)
    {
        $role = $this->userRole;
        return array_key_exists('discountByRoles', $settings) &&
               array_key_exists($role, $settings['discountByRoles']) &&
               array_key_exists($option, $settings['discountByRoles'][$role]);
    }
    
    public function getPrice($product)
    {
        return $this->products->getRolePrice($product);
    } // end getPrice
    
    public function getSalePrice($product)
    {
        return $this->products->getRoleSalePrice($product);
    }
    
    public function getRolePriceOrSale($product)
    {
        $salePrice = $this->getSalePrice($product);
        
        if ($salePrice && $this->_isDefaultCurrencyActive()) {
            return $salePrice;
        }
        
        return  $this->getPrice($product);
    }
    
    private function _isRolePriceDiscountTypeEnabled()
    {
        $settings = $this->getSettings();
        $userRole = $this->userRole;
        
        if (!$settings) {
            return false;
        }
        
        if (!isset($settings['discountByRoles'][$userRole]['priceType'])) {
            return false;
        }
        
        $priceType = $settings['discountByRoles'][$userRole]['priceType'];
        
        return $priceType == PRICE_BY_ROLE_DISCOUNT_TYPE_ROLE_PRICE;
    } // end _isRolePriceDiscountTypeEnabled
    
    public function getAmountOfDiscountOrMarkUp()
    {
        $settings = $this->getSettings();
       
        if (!$this->_hasOptionByDiscountRoles('value', $settings)) {
            return false;
        }
        return $settings['discountByRoles'][$this->userRole]['value'];
    } // end getAmountOfDiscountOrMarkUp
    
    public function onReplaceAllPriceToTextInSomeProductFilter($price, $product)
    {
        return WooUserRoleModule::get('HidePrice')
            ->onReplaceAllPriceToTextInSomeProductFilter($price, $product);
    } // end onReplaceAllPriceToTextInSomeProductFilter
        
    // FIXME: PPC
    public function createProductInstance($idProduct, $params = array())
    {
        $wooFactory = new WC_Product_Factory();
        $product = $wooFactory->get_product($idProduct);
        return $product;
    } // end createProductInstance
    
    // FIXME: PPC
    public function getProductNewInstance($product)
    { 
        $params = array(
            'product_type' => $this->_ecommerceFacade->getProductType($product)
        );
        
        $idProduct = $this->getProductIdFromProductInstance($product);
       
        if (!$idProduct) {
            throw new Exception('Undefined product Id');
        }

        return $this->createProductInstance($idProduct, $params);
    } // end getProductNewInstance
    
    protected function getProductIdFromProductInstance($product)
    {
        $facade = &$this->_ecommerceFacade;
        if ($this->_hasVariationIdInProductInstance($product)) {
            $producId = $facade->getVariationProductID($product);
        } else {
            $producId = $facade->getProductID($product);
        }
        
        return $producId;
    } // end getProductIdFromProductInstance
    
    private function _hasVariationIdInProductInstance($product)
    {
        return (bool) $this->_ecommerceFacade->getVariationProductID($product);
    } // end _hasVariationIdInProductInstance
    
    public function isProductPage()
    {
        return is_product();
    } // end isProductPage
    
    public function onRemoveAddToCartButtonInSomeProductsFilter(
        $button, $product
    )
    {
        return WooUserRoleModule::get('HidePrice')
            ->onRemoveAddToCartButtonInSomeProductsFilter($button, $product);
    } // end onRemoveAddToCartButtonInSomeProductsFilter
    
    public function onReplaceAllPriceToTextInAllProductFilter()
    {
        return $this->fetchContentInsteadOfPrices();
    } //end onReplaceAllPriceToTextInAllProductFilter
    
    public function fetchContentInsteadOfPrices()
    {
        $vars = array(
            'text' => $this->textInsteadPrices
        );
        
        return $this->fetch('custom_text.phtml', $vars);
    } // end fetchContentInsteadOfPrices
     
    public function removeGroupedAddToCartLinkAction()
    {
        $vars = array(
            'settings' => $this->getSettings(),
        );
        echo $this->fetch('hide_grouped_add_to_cart_buttons.phtml', $vars);
    } // end removeGroupedAddToCartLinkAction
    
    public function removeVariableAddToCartLinkAction()
    {
        $vars = array(
            'settings' => $this->getSettings(),
        );
        echo $this->fetch('hide_variable_add_to_cart_buttons.phtml', $vars);
    } // end removeVariableAddToCartLinkAction

    public function onRemoveAllAddToCartButtonFilter($button, $product)
    {
        if ($this->_hasAddToCartButtonText($product)) {
            $settings = $this->getSettings();
            return $settings['textForNonRegisteredUsers'];
        }
        
        return $button;
    } // end onRemoveAddToCartButtonFilter
    
    private function _hasAddToCartButtonText($product)
    {
        $facade = &$this->_ecommerceFacade;
        return $facade->isProductPurchasableAndInStock($product);
    } // _hasAddToCartButtonText
    
    public function isAddToCartButtonHiddenAndProductPurchasable($product)
    {
        $settings = $this->getSettings();
        $facade = &$this->_ecommerceFacade;
        return array_key_exists('textForNonRegisteredUsers', $settings) && 
               $facade->isProductPurchasableAndInStock($product);
    } // end isAddToCartButtonHiddenAndProductPurchasable
    
    public function isRegisteredUser()
    {
        return $this->userRole;
    } // end isRegisteredUser

    public function getPluginTemplatePath($fileName)
    {
        return $this->_pluginTemplatePath.'frontend/'.$fileName;
    } // end getPluginTemplatePath
    
    public function getPluginJsUrl($fileName)
    {
        return $this->_pluginJsUrl.'frontend/'.$fileName;
    } // end getPluginJsUrl
    
    public function getPluginCssUrl($path) 
    {
        return $this->_pluginUrl.$path;
    } // end getPluginCssUrl
    
    public function onInitJsAction()
    {
        $this->onEnqueueJsFileAction('jquery');
        $this->onEnqueueJsFileAction(
            'festi-user-role-prices-general',
            'general.js',
            'jquery',
            $this->_version
        );
    } // end onInitJsAction
    
    public function onInitCssAction()
    {
        $this->addActionListener(
            'wp_head',
            'appendCssToHeaderForCustomerSavingsCustomize'
        );

        $this->onEnqueueCssFileAction(
            'festi-user-role-prices-styles',
            'static/styles/frontend/style.css',
            array(),
            $this->_version
        );
    } // end onInitCssAction
    
    public function appendCssToHeaderForCustomerSavingsCustomize()
    {
        if (!$this->hasOptionInSettings('showCustomerSavings')) {
            return false;
        }
        
        $vars = array(
            'settings' => $this->getSettings(),
        );

        echo $this->fetch('customer_savings_customize_style.phtml', $vars);
    } // end appendCssToHeaderForPriceCustomize
    
    public function hasOptionInSettings($option)
    {
        $settings = $this->getSettings();

        return array_key_exists($option, $settings);
    } // end hasOptionInSettings
    
    public function isWoocommerceMultiLanguageActive()
    {
        $pluginPath = 'woocommerce-multilingual/wpml-woocommerce.php';
        
        return $this->isPluginActive($pluginPath);
    } // end isWoocommerceMultiLanguageActive

    public function onDisplayOnlyProductStockStatusAction()
    {
        $vars = array(
            'settings' => $this->getSettings(),
        );
        echo $this->fetch('stock_status_for_simple_type_product.phtml', $vars);
    } // end onDisplayOnlyProductStockStatusAction
}