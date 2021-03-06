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



$installer = $this;

$collection = Mage::getModel('searchindex/index')->getCollection()
    ->addFieldToFilter('index_code', 'mage_catalog_product');

$attributes = array(
    'name' => '100',
);

if ($collection->count() == 0) {
    $index = Mage::getModel('searchindex/index')
        ->setIndexCode('mage_catalog_product')
        ->setTitle('Products')
        ->setPosition(0)
        ->setStatus(3)
        ->setIsActive(1)
        ->setAttributes($attributes)
        ->save();
}

$installer->endSetup();
