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
class BSeller_SkyHub_Block_Adminhtml_Sales_Order_Import_Manual_Form extends BSeller_Core_Block_Adminhtml_Widget_Form
{
    
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('block_form');
    }
    
    
    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var Varien_Data_Form $form */
        $form = new Varien_Data_Form(array(
            'id'     => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post'
        ));
    
        /** @var Varien_Data_Form_Element_Fieldset $fieldset */
        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('Orders Information')
            )
        );
        
        $storeId = (int) $this->_getSession()->getData('simulated_store_id');
        $this->_getSession()->unsetData('simulated_store_id');
        
        /** @var BSeller_SkyHub_Model_System_Config_Source_Store_Available $source */
        $source = Mage::getModel('bseller_skyhub/system_config_source_store_available');
        $fieldset->addField(
            'store_id',
            'select',
            array(
                'name'     => 'store_id',
                'required' => true,
                'options'  => $source->toArray(),
                'label'    => $this->__('Select Store'),
                'note'     => $this->__('The store the order must be imported to.'),
            )
        );
        
        $orderCodes = $this->_getSession()->getData('order_codes');
        $fieldset->addField(
            'order_codes',
            'textarea',
            array(
                'name'     => 'order_codes',
                'required' => true,
                'label'    => $this->__('SkyHub Order Codes'),
                'value'    => $orderCodes,
                'note'     => $this->__('The order codes must be inserted one by line.'),
            )
        );
        
        $form->setValues(array('store_id' => $storeId));
        $form->setUseContainer(true);
        $this->setForm($form);
        
        return $this;
    }
    
    
    /**
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }
}