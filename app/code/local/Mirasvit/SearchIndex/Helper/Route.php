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



class Mirasvit_SearchIndex_Helper_Route extends Mage_Core_Helper_Abstract
{
    public function process(Mage_Core_Controller_Front_Action $controller)
    {
        $request = $controller->getRequest();

        if ($request->isXmlHttpRequest() ||
            !$request->isGet() ||
            strpos($request->getHeader('accept'), 'text/html') === false
        ) {
            return;
        } else {
            $searchText = $this->getSearchQuery($controller->getRequest());

            $message = Mage::helper('searchindex')->__('The page you requested was not found, but we have searched for relevant content.');

            Mage::getSingleton('core/session')->addNotice($message);

            $url = Mage::getUrl('catalogsearch/result', array('_query' => array('q' => $searchText)));
            $controller->getResponse()
                ->clearHeaders()
                ->setRedirect($url);
        }
    }

    /**
     * @param Mage_Core_Controller_Request_Http $request
     *
     * @return string $query
     */
    private function getSearchQuery(Mage_Core_Controller_Request_Http $request)
    {
        $maxQueryLength = ((int) Mage::getStoreConfig('catalog/search/max_query_length') > 0)
            ? (int) Mage::getStoreConfig('catalog/search/max_query_length') : 128;
        $query = preg_replace('/(\W|html|php)+/', ' ', $request->getRequestString());
        if (count($request->getQuery()) > 0) {
            $query .= implode(' ', $request->getQuery());
        }

        return substr($query, 0, $maxQueryLength);
    }
}
