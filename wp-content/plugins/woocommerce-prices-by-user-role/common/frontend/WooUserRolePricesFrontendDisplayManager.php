<?php
    
class WooUserRolePricesFrontendDisplayManager
{
    private $_engine;
    private $_ecommerceFacade;
    
    public function __construct(&$engine)
    {
        $this->_engine = &$engine;
        $this->_ecommerceFacade = EcommerceFactory::getInstance();
    } // end __construct    
   
}