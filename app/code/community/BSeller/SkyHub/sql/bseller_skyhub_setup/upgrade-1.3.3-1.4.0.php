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

/**
 * @var BSeller_SkyHub_Model_Resource_Setup $this
 * @var Magento_Db_Adapter_Pdo_Mysql        $conn
 */

$this->startSetup();


//**********************************************************************************************************************
// Install bseller_skyhub/plp
//**********************************************************************************************************************
$tableName = (string) $this->getTable('bseller_skyhub/plp');

/** @var Varien_Db_Ddl_Table $table */
$table = $this->newTable($tableName)
    ->addColumn(
        'store_id',
        $this::TYPE_INTEGER,
        10,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true
        )
    )
    ->addColumn(
        'skyhub_code',
        $this::TYPE_VARCHAR,
        30,
        array(
            'nullable' => false,
        )
    )
    ->addColumn(
        'expiration_date',
        $this::TYPE_DATE,
        null,
        array(
            'nullable' => false,
        )
    );

$this->addTimestamps($table);
$conn->createTable($table);

$this->addIndex(array('skyhub_code'), $tableName);


//**********************************************************************************************************************
// Install bseller_skyhub/plp_orders
//**********************************************************************************************************************
$tableName = (string) $this->getTable('bseller_skyhub/plp_orders');

/** @var Varien_Db_Ddl_Table $table */
$table = $this->newTable($tableName)
    ->addColumn(
        'plp_id',
        $this::TYPE_INTEGER,
        10,
        array(
            'nullable' => false,
            'primary'  => true,
        )
    )
    ->addColumn(
        'store_id',
        $this::TYPE_INTEGER,
        10,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true
        )
    )
    ->addColumn(
        'skyhub_order_code',
        $this::TYPE_VARCHAR,
        128,
        array(
            'nullable' => false
        )
    )
    ->addColumn(
        'additional_data',
        $this::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
        )
    );

$conn->createTable($table);

$this->addForeignKey($tableName, 'plp_id', 'bseller_skyhub/plp', 'id');

$this->addIndex(array('plp_id'), $tableName, Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX);
$this->addIndex(array('skyhub_order_code'), $tableName, Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX);

$this->endSetup();
