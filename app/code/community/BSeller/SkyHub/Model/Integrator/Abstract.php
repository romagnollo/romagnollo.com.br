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

abstract class BSeller_SkyHub_Model_Integrator_Abstract implements BSeller_SkyHub_Model_Integrator_Interface
{

    use BSeller_SkyHub_Trait_Data,
        BSeller_SkyHub_Trait_Service,
        BSeller_SkyHub_Trait_Config;


    protected $eventPrefix = 'skyub_integrator';
    protected $eventType   = null;
    protected $eventMethod = null;
    protected $eventSuffix = null;
    protected $eventParams = array();


    /**
     * BSeller_SkyHub_Model_Integrator constructor.
     */
    public function __construct()
    {
        $this->init();
    }


    /**
     * @return $this
     */
    protected function init()
    {
        return $this;
    }


    /**
     * @return string
     */
    protected function getEventName()
    {
        return vsprintf('%s_%s_%s_$s', array(
            $this->eventPrefix,
            $this->eventType,
            $this->eventMethod,
            $this->eventSuffix,
        ));
    }


    /**
     * @return $this
     */
    protected function resetEvent()
    {
        $this->eventType   = null;
        $this->eventMethod = null;

        return $this;
    }


    /**
     * @return $this
     */
    protected function beforeIntegration()
    {
        $this->resetEvent();

        $this->eventSuffix = 'before';
        Mage::dispatchEvent($this->getEventName(), (array) $this->eventParams);
        return $this;
    }


    /**
     * @return $this
     */
    protected function afterIntegration()
    {
        $this->eventSuffix = 'after';
        Mage::dispatchEvent($this->getEventName(), (array) $this->eventParams);
        return $this;
    }

}