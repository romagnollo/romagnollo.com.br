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

class BSeller_SkyHub_Model_Integrator_Catalog_Product extends BSeller_SkyHub_Model_Integrator_Abstract
{
    
    use BSeller_SkyHub_Trait_Entity,
        BSeller_SkyHub_Trait_Transformers,
        BSeller_SkyHub_Model_Integrator_Catalog_Product_Validation;

    /** @var string */
    protected $eventType = 'catalog_product';


    /**
     * @param BSeller_SkyHub_Model_Catalog_Product $product
     * @param Mage_Core_Model_Store $store
     *
     * @return bool|\SkyHub\Api\Handler\Response\HandlerInterface
     */
    public function createOrUpdate(Mage_Catalog_Model_Product $product, Mage_Core_Model_Store $store = null)
    {
        if ($store && !(int)$product->getStoreId()) {
            $product->setStoreId($store->getId());
        }

        $exists = $this->productExists($product->getId());

        if (true == $exists) {
            /**
             * Update Product
             *
             * @var bool|\SkyHub\Api\Handler\Response\HandlerInterface $response
             */
            $response = $this->update($product);
            
            if ($response && $response->success()) {
                $this->updateProductEntity($product->getId());
                return $response;
            }
        }

        /** Create Product */
        $response = $this->create($product);

        if ($response && $response->success()) {
            $this->registerProductEntity($product->getId());
        }

        return $response;
    }

    
    /**
     * @param BSeller_SkyHub_Model_Catalog_Product $product
     *
     * @return bool|\SkyHub\Api\Handler\Response\HandlerInterface
     */
    public function create(Mage_Catalog_Model_Product $product)
    {
        /** @var \SkyHub\Api\EntityInterface\Catalog\Product $interface */
        $interface = $this->productTransformer()
                          ->convert($product);

        $this->eventMethod = 'create';
        $this->eventParams = array(
            'product'   => $product,
            'interface' => $interface,
        );

        $this->beforeIntegration();
        $response = $interface->create();
        $this->eventParams[] = $response;
        $this->afterIntegration();

        return $response;
    }
    
    
    /**
     * @param BSeller_SkyHub_Model_Catalog_Product $product
     *
     * @return bool|\SkyHub\Api\Handler\Response\HandlerInterface
     */
    public function update(Mage_Catalog_Model_Product $product)
    {
        /** @var \SkyHub\Api\EntityInterface\Catalog\Product $interface */
        $interface = $this->productTransformer()
                          ->convert($product);

        $this->eventMethod = 'update';
        $this->eventParams = array(
            'product'   => $product,
            'interface' => $interface,
        );

        $this->beforeIntegration();
        $response = $interface->update();
        $this->eventParams[] = $response;
        $this->afterIntegration();

        return $response;
    }
    
    
    /**
     * @param string $sku
     *
     * @return bool|\SkyHub\Api\Handler\Response\HandlerInterface
     */
    public function product($sku)
    {
        if (!$this->validateSku($sku)) {
            return false;
        }

        $this->eventMethod = 'product';
        
        /** @var \SkyHub\Api\EntityInterface\Catalog\Product $interface */
        $interface = $this->api()
                          ->product()
                          ->entityInterface();
        $interface->setSku($sku);

        $this->beforeIntegration();
        $response = $interface->product();
        $this->afterIntegration();

        return $response;
    }
    
    
    /**
     * @param null|bool $statusFilter
     *
     * @return bool|\SkyHub\Api\Handler\Response\HandlerInterface
     */
    public function products($statusFilter = null)
    {
        if (!is_null($statusFilter) || !is_bool($statusFilter)) {
            return false;
        }

        $this->eventMethod = 'products';
        
        /** @var \SkyHub\Api\EntityInterface\Catalog\Product $interface */
        $interface = $this->api()
                          ->product()
                          ->entityInterface();

        $this->beforeIntegration();
        $interface->setStatus($statusFilter);
        $this->afterIntegration();
        
        return $interface->products();
    }
    
    
    /**
     * @return \SkyHub\Api\Handler\Response\HandlerInterface
     */
    public function urls()
    {
        /** @var \SkyHub\Api\EntityInterface\Catalog\Product $interface */
        $interface = $this->api()
                          ->product()
                          ->entityInterface();

        $this->eventMethod = 'urls';

        $this->beforeIntegration();
        $response = $interface->urls();
        $this->afterIntegration();

        return $response;
    }
    
    
    /**
     * @param $sku
     *
     * @return bool|\SkyHub\Api\Handler\Response\HandlerInterface
     */
    public function delete($sku)
    {
        if (!$this->validateSku($sku)) {
            return false;
        }
        
        /** @var \SkyHub\Api\EntityInterface\Catalog\Product $interface */
        $interface = $this->api()
                          ->product()
                          ->entityInterface();
        $interface->setSku($sku);

        $this->eventMethod = 'delete';

        $this->beforeIntegration();
        $response = $interface->delete();
        $this->afterIntegration();

        return $response;
    }
    
    
    /**
     * @param string $sku
     *
     * @return bool
     */
    public function validateSku($sku)
    {
        if (empty($sku)) {
            return false;
        }
        
        return true;
    }
}
