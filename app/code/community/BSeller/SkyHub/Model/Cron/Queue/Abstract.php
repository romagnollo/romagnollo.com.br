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
abstract class BSeller_SkyHub_Model_Cron_Queue_Abstract
    extends BSeller_SkyHub_Model_Cron_Abstract
    implements BSeller_SkyHub_Model_Cron_Queue_Interface
{
    
    /**
     * @param Mage_Cron_Model_Schedule $schedule
     * @param array                    $successIds
     * @param array                    $failIds
     *
     * @return $this
     */
    protected function mergeResults(Mage_Cron_Model_Schedule $schedule, array $successIds = array(), array $failIds = array())
    {
        $successQueueIds = (array) $schedule->getData('success_queue_ids');
        $failedQueueIds  = (array) $schedule->getData('failed_queue_ids');
    
        $successQueueIds = array_unique(array_merge($successQueueIds, $successIds));
        $failedQueueIds  = array_unique(array_merge($failedQueueIds, $failIds));
    
        $schedule->setData('success_queue_ids', $successQueueIds);
        $schedule->setData('failed_queue_ids', $failedQueueIds);
        
        $byStore     = (array) $schedule->getData('by_store');
        $dataByStore = array(
            $this->getStoreId() => array(
                'success_queue_ids' => $successIds,
                'failed_queue_ids'  => $failIds,
            )
        );
        
        $schedule->setData('by_store', array_merge_recursive($byStore, $dataByStore));
        
        return $this;
    }
    
    
    /**
     * @param Mage_Cron_Model_Schedule $schedule
     *
     * @return array
     */
    protected function extractResultSuccessIds(Mage_Cron_Model_Schedule $schedule)
    {
        $successQueueIds = (array) $schedule->getData('success_queue_ids');
        return $successQueueIds;
    }
    
    
    /**
     * @param Mage_Cron_Model_Schedule $schedule
     *
     * @return array
     */
    protected function extractResultFailIds(Mage_Cron_Model_Schedule $schedule)
    {
        $failQueueIds = (array) $schedule->getData('failed_queue_ids');
        return $failQueueIds;
    }
}