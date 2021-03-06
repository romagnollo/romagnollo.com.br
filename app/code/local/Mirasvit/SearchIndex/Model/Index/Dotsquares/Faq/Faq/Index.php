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



class Mirasvit_SearchIndex_Model_Index_Dotsquares_Faq_Faq_Index extends Mirasvit_SearchIndex_Model_Index
{
    public function getBaseGroup()
    {
        return 'Dotsquares';
    }

    public function getBaseTitle()
    {
        return 'FAQ';
    }

    public function canUse()
    {
        return Mage::getConfig()->getModuleConfig('Dotsquares_Faq')->is('active', 'true');
    }

    public function getPrimaryKey()
    {
        return 'entity_id';
    }

    public function getAvailableAttributes()
    {
        $result = array(
            'title' => Mage::helper('searchindex')->__('Title'),
            'description' => Mage::helper('searchindex')->__('Description'),
        );

        return $result;
    }

    public function getCollection()
    {
        $collection = Mage::getModel('faq/faq')->getCollection();
        $collection->addFieldToFilter('main_table.status', 1);

        $this->joinMatched($collection, 'main_table.entity_id');

        return $collection;
    }
}
