<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/extension_searchsphinx
 * @version   2.3.48
 * @copyright Copyright (C) 2020 Mirasvit (https://mirasvit.com/)
 */



class Mirasvit_SearchIndex_Block_Adminhtml_Validation_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setDestElementId('validate_form');
    }

    protected function _beforeToHtml()
    {
        $this->addTab('validate_result', array(
            'label' => Mage::helper('searchindex')->__('Validate Result'),
            'title' => Mage::helper('searchindex')->__('Validate Result'),
            'content' => $this->getLayout()->createBlock('searchindex/adminhtml_validation_tab_result')->toHtml(),
        ));
        $this->addTab('validate_speed', array(
            'label' => Mage::helper('searchindex')->__('Validate Speed'),
            'title' => Mage::helper('searchindex')->__('Valdate Speed'),
            'content' => $this->getLayout()->createBlock('searchindex/adminhtml_validation_tab_speed')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
