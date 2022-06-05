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

class BSeller_SkyHub_Controller_Admin_Action extends BSeller_Core_Controller_Adminhtml_Action
{

    use BSeller_SkyHub_Trait_Data,
        BSeller_SkyHub_Trait_Processors,
        BSeller_SkyHub_Trait_Config,
        BSeller_SkyHub_Trait_Store_Iterator;


    /**
     * @var string
     * @var string
     */
    protected $_aclPrefix = 'bseller/bseller_skyhub/';
    protected $_aclSuffix = '';


    /**
     * @param null|string $actionTitle
     *
     * @return $this
     */
    protected function init($actionTitle = null)
    {
        $this->loadLayout();
        $this->_title($this->__('BSeller SkyHub'));

        if (!empty($actionTitle)) {
            $this->_title($this->__($actionTitle));
        }

        return $this;
    }


    /**
     * @return Mage_Admin_Model_Session
     */
    protected function _getAclSession()
    {
        return Mage::getSingleton('admin/session');
    }


    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        $session = $this->_getAclSession();
        return $session->isAllowed($this->_aclPrefix.$this->_aclSuffix);
    }
}