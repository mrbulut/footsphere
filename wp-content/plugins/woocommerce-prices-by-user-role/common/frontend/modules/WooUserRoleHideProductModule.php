<?php
    
class WooUserRoleHideProductModule extends AbstractWooUserRoleModule
{
    public function onHideProductByUserRole($query)
    {
        $hideProducts = $this->engine->getOptions(
            PRICE_BY_ROLE_HIDDEN_PRODUCT_OPTIONS
        );

        if (!$hideProducts) {
            $hideProducts = array();
        }

        if ($this->_hasHideProductByUserRole($hideProducts)) {
            $idProduct = $hideProducts[$this->engine->userRole];
            $query->set('post__not_in', $idProduct);
        }
    } // end onHideProductByUserRole
    
    private function _hasHideProductByUserRole($hideProducts)
    {
        return !is_admin()
               && $this->engine->userRole
               && array_key_exists($this->engine->userRole, $hideProducts);
    } // end _hasHideProductByUserRole
}