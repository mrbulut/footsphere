<?php
    
abstract class AbstractWooUserRoleModule
{
    protected $engine;
    protected $ecommerceFacade;
    protected static $_engine;
    
    public function __construct()
    {
        $this->engine = &static::$_engine;
        $this->ecommerceFacade = EcommerceFactory::getInstance();
    }
}