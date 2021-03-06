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
 * @package   mirasvit/extension_mcore
 * @version   1.0.24
 * @copyright Copyright (C) 2020 Mirasvit (https://mirasvit.com/)
 */


class Mirasvit_MstCore_Model_Resource_Logger extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('mstcore/logger', 'log_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if(!$object->getLevel()) {
            $object->getLevel(Mirasvit_MstCore_Model_Logger::LOG_LEVEL_NOTICE);
        }

        if ($object->isObjectNew() && !$object->hasCreatedAt()) {
            $object->setCreatedAt(Mage::getSingleton('core/date')->gmtDate());
        }

        return parent::_beforeSave($object);
    }
}