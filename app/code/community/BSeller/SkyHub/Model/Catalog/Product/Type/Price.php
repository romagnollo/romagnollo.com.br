<?php
/**
 * BSeller Platform | B2W - Companhia Digital
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  BSeller
 * @package   BSeller_SkyHub
 *
 * @copyright Copyright (c) 2018 B2W Digital - BSeller Platform. (http://www.bseller.com.br)
 *
 * Access https://ajuda.skyhub.com.br/hc/pt-br/requests/new for questions and other requests.
 */
trait BSeller_SkyHub_Model_Catalog_Product_Type_Price
{
    
    use BSeller_SkyHub_Trait_Data;
    
    
    /**
     * Get product final price
     *
     * @param   double $qty
     * @param   Mage_Catalog_Model_Product $product
     * @return  double
     */
    public function getFinalPrice($qty = null, $product)
    {
        $skyhubConfig = $this->extractSkyhubConfig($product);
        $finalPrice   = (float) $this->arrayExtract($skyhubConfig, 'final_price');
        
        if (empty($skyhubConfig) || !$finalPrice) {
            return parent::getFinalPrice($qty, $product);
        }
        
        return $finalPrice;
    }
    
    
    /**
     * @param Mage_Catalog_Model_Product $product
     *
     * @return array|mixed
     */
    protected function extractSkyhubConfig(Mage_Catalog_Model_Product $product)
    {
        $key = 'skyhub_product_configuration';
    
        /**
         * If it's a configurable product it will return from here.
         */
        if ($skyhubConfig = (array) $product->getData($key)) {
            return $skyhubConfig;
        }
    
        /**
         * If it's a grouped product it will return from here.
         *
         * @var Mage_Sales_Model_Quote_Item_Option $productType
         */
        $productType = $product->getCustomOption('product_type');
        
        if ($productType) {
            $product = $productType->getProduct();
            
            if ($product) {
                $skyhubConfig = (array) $product->getData($key);
            }
        }
        
        if ($skyhubConfig) {
            return (array) $skyhubConfig;
        }
        
        return array();
    }
}
