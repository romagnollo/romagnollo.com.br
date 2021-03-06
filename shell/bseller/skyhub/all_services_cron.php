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
require 'abstract.php';

class BSeller_SkyHub_Shell_BSeller_Skyhub_AllServicesCron extends BSeller_SkyHub_Shell_Abstract
{
    public function run()
    {
        $schedule = $this->getSchedule();

        //product attributes
        Mage::getModel('bseller_skyhub/cron_queue_catalog_product_attribute')->create($schedule);
        Mage::getModel('bseller_skyhub/cron_queue_catalog_product_attribute')->execute($schedule);

        //products
        Mage::getModel('bseller_skyhub/cron_queue_catalog_product')->create($schedule);
        Mage::getModel('bseller_skyhub/cron_queue_catalog_product')->execute($schedule);

        //import orders
        Mage::getModel('bseller_skyhub/cron_queue_sales_order_queue')->execute($schedule);

        //update order status
        Mage::getModel('bseller_skyhub/cron_queue_sales_order_status')->create($schedule);
        Mage::getModel('bseller_skyhub/cron_queue_sales_order_status')->execute($schedule);
    }
}

(new BSeller_SkyHub_Shell_BSeller_Skyhub_AllServicesCron())->run();