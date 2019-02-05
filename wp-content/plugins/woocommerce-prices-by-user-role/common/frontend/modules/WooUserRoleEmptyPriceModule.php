<?php

class WooUserRoleEmptyPriceModule extends AbstractWooUserRoleModule
{
    public function isDisplayTextInsteadOfPriceEnabled()
    {
        if (!$this->engine->getUserRole()) {
            return false;
        }

        $settings = $this->engine->getOptions('settings');
        
        if (!$settings) {
            $settings = array();
        }
        
        $userRole = $this->engine->getUserRole();

        return array_key_exists('hideEmptyPrice', $settings) &&
               !empty($settings['hideEmptyPrice']) &&
               array_key_exists($userRole, $settings['hideEmptyPrice']);
    } // end isDisplayTextInsteadOfPriceEnabled
    
    public function onGetTextInsteadOfEmptyPrice()
    {
        $settings = $this->engine->getOptions('settings');
        $textInsteadOfEmptyPrice = $settings['textForEmptyPrice'];
        $vars = array(
            'text' => $textInsteadOfEmptyPrice
        );
        
        return $this->engine->fetch('custom_text.phtml', $vars);
    } // end onGetTextInsteadOfEmptyPrice
    
    public function onHideEmptyPrice()
    {
        if ($this->isDisplayTextInsteadOfPriceEnabled()) {
            $this->engine->addFilterListener(
                'woocommerce_empty_price_html',
                'onGetTextInsteadOfEmptyPrice'
            );
                
            return true;
        }
        
        return false;
    } // end onHideEmptyPrice
}