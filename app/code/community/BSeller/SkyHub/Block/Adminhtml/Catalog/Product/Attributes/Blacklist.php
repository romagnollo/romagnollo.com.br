<?php
/**
 * BSeller Platform | B2W - Companhia Digital
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  BSeller
 * @package   BSeller_SkyHub
 *
 * @copyright Copyright (c) 2019 B2W Digital - BSeller Platform. (http://www.bseller.com.br)
 * Access https://ajuda.skyhub.com.br/hc/pt-br/requests/new for questions and other requests.
 */
class BSeller_SkyHub_Block_Adminhtml_Catalog_Product_Attributes_Blacklist extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_blockGroup = 'bseller_skyhub';
    protected $_controller = 'adminhtml_catalog_product_attributes_blacklist';

    /**
     * BSeller_SkyHub_Block_Adminhtml_Catalog_Product_Attributes_Blacklist constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->removeButton('delete');
        $this->_updateButton('save', 'label', $this->__('Save'));
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
        return $this->__('Product Attributes Blacklist - Skyhub');
    }

    /**
     * @return string
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save');
    }
}