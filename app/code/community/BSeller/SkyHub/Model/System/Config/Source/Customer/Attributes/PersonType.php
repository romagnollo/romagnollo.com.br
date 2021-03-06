<?php

/**
 * BSeller - B2W Companhia Digital
 *
 * DISCLAIMER
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @copyright     Copyright (c) 2017 B2W Companhia Digital. (http://www.bseller.com.br/)
 *
 * Access https://ajuda.skyhub.com.br/hc/pt-br/requests/new for questions and other requests.
 */
class BSeller_SkyHub_Model_System_Config_Source_Customer_Attributes_PersonType
    extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * All options in array
     *
     * @var array
     */
    protected $_options = array(
        0 => '- - Select - -',
        1 => 'Physical Person',
        2 => 'Legal Person',
    );

    /**
     * Return options in select format
     *
     * @return array
     */
    public function getAllOptions()
    {
        $data = array();

        foreach ($this->_options as $value => $label) {
            $data[] = array(
                'value' => $value,
                'label' => Mage::helper('bseller_skyhub')->__($label)
            );
        }

        return $data;
    }

    /**
     * Return options in key-value format
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getAllOptions();
    }
}