<?php

class WooUserRoleSystemModule extends AbstractWooUserRoleModule
{
    public function isSesionStarted()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE;
            } else {
                return session_id() !== '';
            }
        } else if (defined('WP_TESTS_TABLE_PREFIX')) {
            return true;
        }
        
        return false;
    } // end isSesionStarted
    
    private function _getMaxExecutionTime()
    {
        return ini_get('max_execution_time');
    } // end _getMaxExecutionTime

    public function isMaxExecutionTimeLowerThanConstant()
    {
        $executionTime = WooUserRolePricesFestiPlugin::MAX_EXECUTION_TIME;
        return $this->_getMaxExecutionTime() < $executionTime;
    } // end _isMaxExecutionTimeLowerThanConstant
}