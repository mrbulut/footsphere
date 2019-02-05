<?php

class WooCommerceButterflyAdapter extends EcommerceFacade
{
    public function getHookNameForWritePanels()
    {
        return "woocommerce_product_data_panels";
    } // end getHookNameForWritePanels
    
    public function getHookNameForGetPrice()
    {
        return "woocommerce_product_get_price";
    } // end getHookNameForGetPrice
       
    public function getProductType($product)
    {
        return $product->get_type();
    } // end getProductType
    
    public function getVariationProductID($product)
    {
        return $product->get_id();
    } // end getVariationProductID
    
    public function isChildProduct($product)
    {
        return (bool) $product->get_parent_id();
    } // end isChildProduct
    
    public function getProductParentID($product)
    {
        return $product->get_parent_id();
    } // end getProductParentID
    
    public function getProductID($product)
    {
        return $product->get_id();
    } // end getProductID
    
    public function getPriceExcludingTax($product, $options)
    {
        return wc_get_price_excluding_tax($product, $options);
    } // end getPriceExcludingTax
    
    public function getPriceIncludingTax($product, $options)
    {
        return wc_get_price_including_tax($product, $options);
    } // end getPriceIncludingTax
    
    public function getPricesFromVariationProduct($product)
    {
        $prices = array();
        $productIDs = $product->get_children();

        foreach ($productIDs as $productID) {
            $product = wc_get_product($productID);
            $prices[$productID] = $product->get_price();
        }
        
        return $prices;
    } // end getPricesFromVariationProduct
}
