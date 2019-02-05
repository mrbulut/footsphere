<?php

class WooUserRoleHidePriceModule extends AbstractWooUserRoleModule
{
    public function onHidePrice()
    {
        if (!$this->_hasAvailableRoleToViewPricesInAllProducts()) {
            $this->engine->products->replaceAllPriceToText();
            $this->engine->removeFilter(
                'woocommerce_get_price_html',
                array(
                    $this->engine,
                    'onDisplayCustomerSavingsFilter',
                )
            );
            
            $this->_doHideSubscriptionProductPrice();   
            
        } else {
            $this->engine->products->replaceAllPriceToTextInSomeProduct();
        }
    } // end onHidePrice
    
    private function _doHideSubscriptionProductPrice()
    {
        $this->engine->addFilterListener(
            'woocommerce_subscriptions_product_price_string',
            array(
                $this->engine,
                'onReplaceAllPriceToTextInAllProductFilter',
            ),
            10,
            3
        );
        $this->engine->addFilterListener(
            'woocommerce_variable_subscription_price_html',
            array(
                $this->engine,
                'onReplaceAllPriceToTextInAllProductFilter',
            ),
            10,
            2
        );
        
        $this->engine->addFilterListener(
            'woocommerce_order_formatted_line_subtotal',
            array(
                $this->engine,
                'onReplaceAllPriceToTextInAllProductFilter',
            ),
            10,
            2
        );
        
        $this->engine->addFilterListener(
            'woocommerce_order_subtotal_to_display',
            array(
                $this->engine,
                'onReplaceAllPriceToTextInAllProductFilter',
            ),
            10,
            2
        );
        
        $this->engine->addFilterListener(
            'woocommerce_get_formatted_order_total',
            array(
                $this->engine,
                'onReplaceAllPriceToTextInAllProductFilter',
            ),
            10,
            2
        );
    } // end _doHideSubscriptionProductPrice
    
    public function onProductPriceOnlyRegisteredUsers($price)
    {
       if (!$this->_hasAvailableRoleToViewPricesInAllProducts()) {
           $price = $this->engine->getTextInsteadPrices();
       }
       
       return $price;
    } // end onProductPriceOnlyRegisteredUsers
    
    private function _hasAvailableRoleToViewPricesInAllProducts()
    {
        if (!$this->_isAvailablePriceInAllProductsForUnregisteredUsers()) {
            $this->_setValueForContentInsteadOfPrices('textForUnregisterUsers');
            return false;
        }

        if (!$this->_isAvailablePriceInAllProductsForRegisteredUsers()) {
            $this->_setValueForContentInsteadOfPrices('textForRegisterUsers');
            return false;
        }

        return true;
    } // end _hasAvailableRoleToViewPricesInAllProducts
    
    public function onRemovePriceForUnregisteredUsers($price, $product)
    {
        if ($this->_hasReadMoreButtonText($price)) {
            return $price;
        }
        
        if (!$this->_isAvailablePriceInAllProductsForUnregisteredUsers()) {
             $price = null;
        }
        
        return $price;
    } // end onRemovePriceForUnregisteredUsers
    
    private function _hasReadMoreButtonText($price)
    {
        return $price === $this-> ecommerceFacade->getEmptyPriceSymbol();
    } // end _hasReadMoreButtonText
    
    private function _isAvailablePriceInAllProductsForUnregisteredUsers()
    {
        return $this->engine->isRegisteredUser() || 
               (!$this->engine->isRegisteredUser() && 
               !$this->_hasOnlyRegisteredUsersInGeneralSettings());
    } //end _isAvailablePriceInAllProductsForUnregisteredUsers
    
    private function _hasOnlyRegisteredUsersInGeneralSettings()
    {
        $settings = $this->engine->getSettings();
        return array_key_exists('onlyRegisteredUsers', $settings);
    } // end _hasOnlyRegisteredUsersInGeneralSettings
    
    private function _isAvailablePriceInAllProductsForRegisteredUsers()
    {
        return !$this->engine->isRegisteredUser() || 
               ($this->engine->isRegisteredUser()
               && !$this->_hasHidePriceOptionForRoleInGeneralSettings());
    } //end _isAvailablePriceInAllProductsForRegisteredUsers
    
    private function _hasHidePriceOptionForRoleInGeneralSettings()
    {
        $settings = $this->engine->getSettings();

        $role = $this->engine->userRole;
           
        return array_key_exists('hidePriceForUserRoles', $settings)
               && array_key_exists($role, $settings['hidePriceForUserRoles']);
    } // end _hasHidePriceOptionForRoleInGeneralSettings
    
    public function onReplaceAllPriceToTextInSomeProductFilter($price, $product)
    {
        $product = $this->engine->getProductNewInstance($product);
        
        if (!$this->_hasAvailableRoleToViewPricesInProduct($product)) {
            $text = $this->engine->getTextInsteadPrices();
            
            $fetchManager = new WooUserRolePricesFrontendDisplayManager(
                $this->engine
            );
            return $fetchManager->fetchContentInsteadOfPrices($text);
        }

        if ($this->_isGuestUserTextEnabled()) {
            $guestText = $this->_getGuestUserCustomText();

            $vars = array(
                'text' => $guestText
            );

            $template = $this->engine->fetch('guest_text.phtml', $vars);
            $price .= $template;
        };
        
        return $price;
    } // end onReplaceAllPriceToTextInSomeProductFilter
    
    public function onHideAddToCartButton()
    {
        if ($this->_isEnabledHideAddToCartButtonOptionInAllProducts()) {
            $this->_removeAllAddToCartButtons();
        } else {
            $this->_removeAddToCartButtonsInSomeProduct();
        }
    } // end onHideAddToCartButton
    
    private function _isEnabledHideAddToCartButtonOptionInAllProducts()
    {
        return (!$this->engine->isRegisteredUser() 
                  && $this->_hasHideAddToCartButtonOptionInSettings())
               || ($this->engine->isRegisteredUser() 
                  && $this->_hasHideAddToCartButtonOptionForUserRole());
    } // end _isEnabledHideAddToCartButtonOptionInAllProducts
    
    private function _hasHideAddToCartButtonOptionInSettings()
    {
        $settings = $this->engine->getSettings();
            
        return array_key_exists('hideAddToCartButton', $settings);
    } //end _hasHideAddToCartButtonOptionInSettings
    
    private function _hasHideAddToCartButtonOptionForUserRole()
    {
        $key = 'hideAddToCartButtonForUserRoles';
        $settings = $this->engine->getSettings();
        
        return array_key_exists($key, $settings)
               && array_key_exists($this->engine->userRole, $settings[$key]);
    } //end _hasHideAddToCartButtonOptionForUserRole
    
    private function _removeAddToCartButtonsInSomeProduct()
    {
        $this->engine->products->removeLoopAddToCartLinksInSomeProducts();
        $this->_removeAddToCartButtonInProductPage();
    } // end _removeAddToCartButtonsInSomeProduct
    
    private function _removeAddToCartButtonInProductPage()
    {
        if (!$this->engine->isProductPage()) {
            return false;
        }
        
        $idProduct = get_the_ID();
        $product = $this->engine->createProductInstance($idProduct);
        
        if (!$this->_hasAvailableRoleToViewPricesInProduct($product)) {
            $type = $this-> ecommerceFacade->getProductType($product);
            $this->engine->products->removeAddToCartButton($type);
        }
        
    } // end _removeAddToCartButtonInProductPage
    
    public function onRemoveAddToCartButtonInSomeProductsFilter(
        $button, $product
    )
    {
        $product = $this->engine->getProductNewInstance($product);
        
        if (!$this->_hasAvailableRoleToViewPricesInProduct($product)) {
            return '';
        }

        return $button;
    } // end onRemoveAddToCartButtonInSomeProductsFilter
    
    private function _hasAvailableRoleToViewPricesInProduct($product)
    {
        if ($this->_isChildProduct($product)) {
            $parentID = $this-> ecommerceFacade->getProductParentID($product);
            $product = $this->engine->createProductInstance($parentID);
        }

        if (!$this->_isAvailablePriceInProductForUnregisteredUsers($product)) {
            $this->_setValueForContentInsteadOfPrices('textForUnregisterUsers');
            return false;
        }
    
        if (!$this->_isAvailablePriceInProductForRegisteredUsers($product)) {
            $this->_setValueForContentInsteadOfPrices('textForRegisterUsers');
            return false;
        }
        
        return true;
    } // end _hasAvailableRoleToViewPricesInProduct
    
    private function _isChildProduct($product)
    {
        return $this-> ecommerceFacade->isChildProduct($product);
    } // end _isChildProduct
    
    private function _isAvailablePriceInProductForUnregisteredUsers($product)
    {
        return $this->engine->isRegisteredUser() || 
               (!$this->engine->isRegisteredUser()
               && !$this->_hasOnlyRegisteredUsersInProductSettings($product));
    } // end _isAvailablePriceInProductForUnregisteredUsers
    
    private function _hasOnlyRegisteredUsersInProductSettings($product)
    {
        $produtcId = $this-> ecommerceFacade->getProductID($product);
        
        if (!$produtcId) {
            return false;
        }

        $options = $this->engine->getMetaOptions(
            $produtcId,
            PRICE_BY_ROLE_HIDDEN_RICE_META_KEY
        );
       
        if (!$options) {
            return false;
        }

        return array_key_exists('onlyRegisteredUsers', $options);
    } // end _hasOnlyRegisteredUsersInProductSettings
    
    private function _isAvailablePriceInProductForRegisteredUsers($product)
    {
        return !$this->engine->isRegisteredUser() || 
               ($this->engine->isRegisteredUser() &&
               !$this->_hasHidePriceOptionForRoleInProductSettings($product));
    } // end _isAvailablePriceInProductForRegisteredUsers
    
    private function _hasHidePriceOptionForRoleInProductSettings($product)
    { 
        $produtcId = $this-> ecommerceFacade->getProductID($product);
        
        if (!$produtcId) {
            return false;
        }
        
        $options = $this->engine->getMetaOptions(
            $produtcId,
            PRICE_BY_ROLE_HIDDEN_RICE_META_KEY
        );
        
        if (!$options) {
            return false;
        }
        
        if (!array_key_exists('hidePriceForUserRoles', $options)) {
            return false;
        }
        
        return $options && array_key_exists(
            $this->engine->userRole,
            $options['hidePriceForUserRoles']
        );
    } // end _hasHidePriceOptionForRoleInProductSettings

    private function _setValueForContentInsteadOfPrices($optionName)
    {
        $settings = $this->engine->getSettings();
        
        $this->engine->setTextInsteadPrices($settings[$optionName]);
    } // end _setValueForContentInsteadOfPrices
    
    private function _removeAllAddToCartButtons()
    {
        $this->engine->products->removeAllLoopAddToCartLinks();
        $this->engine->products->removeAddToCartButton();
    } //end _removeAllAddToCartButtons

    private function _getGuestUserCustomText()
    {
        $settings = $this->engine->getSettings();

        if (array_key_exists('guestUserTextArea', $settings)) {
            return $settings['guestUserTextArea'];
        }

        return false;
    } // end _getGuestUserCustomText

    private function _isGuestUserTextEnabled()
    {
        $settings = $this->engine->getSettings();

        return !$this->engine->isRegisteredUser() &&
               $this->engine->isProductPage() &&
               array_key_exists('guestUserStatus', $settings);

    } // end _isGuestUserTextEnabled
}