<?php

require_once __DIR__.'/AbstractWooUserRoleModule.php';

class WooUserRoleModule extends AbstractWooUserRoleModule
{
    private static $_modules = array();
    private static $_instance = null;
    
    
    public static function init(&$engine)
    {
        static::$_engine = $engine;
    }
    
    public static function &get($module)
    {
        if (empty(static::$_engine)) {
            $msg = __('No Init module. Use WooUserRoleModule::init($this)');
            throw new WooUserRoleModuleException($msg);
        }
        
        if (isset(self::$_modules[$module])) {
            return self::$_modules[$module];
        }
        
        $className = 'WooUserRole'.$module.'Module';

        if (!class_exists($className)) {
            $path = __DIR__.'/'.$className.'.php';
            if (!include_once($path)) {
                $msg = sprintf('Not Found %s Module', $className);
                throw new WooUserRoleModuleException($msg);
            }
        }
        
        self::$_modules[$module] = new $className();
        
        return self::$_modules[$module];
    }
}

class WooUserRoleModuleException extends Exception
{
}