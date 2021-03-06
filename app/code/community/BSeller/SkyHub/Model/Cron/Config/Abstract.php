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

abstract class BSeller_SkyHub_Model_Cron_Config_Abstract implements BSeller_SkyHub_Model_Cron_Config_Interface
{

    use BSeller_SkyHub_Trait_Config;


    /** @var string */
    protected $group = '';

    /** @var string */
    protected $enabledField = 'enabled';


    /**
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isEnabled($storeId = null)
    {
        return (bool) $this->getSkyHubModuleConfig($this->enabledField, $this->group, $storeId);
    }


    /**
     * @param string   $field
     * @param int|null $storeId
     *
     * @return mixed
     */
    public function getGroupConfig($field, $storeId = null)
    {
        return $this->getSkyHubModuleConfig($field, $this->group, $storeId);
    }
}
