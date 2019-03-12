<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 16:33
 */

class ConfigReader
{
    public function Read($route = null,$key=null)
    {
        if ($route != null) {
            $config = $GLOBALS[$key];
            $route = explode("/", $route);
            foreach ($route as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        require false;
    }
}
