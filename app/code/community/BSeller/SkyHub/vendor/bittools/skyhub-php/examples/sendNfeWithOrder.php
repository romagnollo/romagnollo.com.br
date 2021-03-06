<?php
/**
 * BSeller Platform | B2W - Companhia Digital
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  SkyHub
 * @package   SkyHub
 *
 * @copyright Copyright (c) 2021 B2W Digital - BSeller Platform. (http://www.bseller.com.br)
 */
require_once dirname(__FILE__) . '/../vendor/autoload.php';
$email   = 'teste@teste.com';
$apiKey  = '123terreddrrre';

$service = new SkyHub\Api\Service\ServiceMultipart();
/** @var \SkyHub\Api $api */
$api = new SkyHub\Api($email, $apiKey, null, null, $service);
$result = $api->order()->invoiceB2wDirect(
    'Americanas-1234',
    '1',
    '2021-01-27T12:30:00-03:00',
    '../exemplo_nfe_xml.xml',
    'nfe_xml.xml'
);
print_r($result->export());