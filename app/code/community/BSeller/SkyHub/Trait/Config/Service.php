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

trait BSeller_SkyHub_Trait_Config_Service
{
    
    /**
     * @param string $field
     * @param int    $storeId
     *
     * @return string|integer
     */
    protected function getServiceConfig($field, $storeId = null)
    {
        try {
            $store = Mage::app()->getStore($storeId);
        } catch (Exception $e) {}
        
        return $this->getSkyHubModuleConfig($field, 'service', $store);
    }


    /**
     * @param int $storeId
     *
     * @return string
     */
    protected function getServiceBaseUri($storeId = null)
    {
        return (string) $this->getServiceConfig('base_uri', $storeId);
    }


    /**
     * @return string
     */
    protected function getServiceEmail($storeId = null)
    {
        return (string) $this->getServiceConfig('email', $storeId);
    }


    /**
     * @return string
     */
    protected function getServiceApiKey($storeId = null)
    {
        return (string) $this->getServiceConfig('api_key', $storeId);
    }


    /**
     * @param int|null $storeId
     *
     * @return bool
     */
    protected function isConfigurationOk($storeId = null)
    {
        if (!$this->getServiceBaseUri($storeId)) {
            return false;
        }

        if (!$this->getServiceEmail($storeId)) {
            return false;
        }

        if (!$this->getServiceApiKey($storeId)) {
            return false;
        }

        return true;
    }

}