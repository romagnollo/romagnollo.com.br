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



class Mirasvit_SearchIndex_Model_Config
{
    public function getMergeExpressins()
    {
        $expressions = array();

        $matchExpr = Mage::getStoreConfig('searchsphinx/merge/match_expr');
        $replaceExpr = Mage::getStoreConfig('searchsphinx/merge/replace_expr');
        $replaceChar = Mage::getStoreConfig('searchsphinx/merge/replace_char');

        $matchExpr = explode('|', $matchExpr);
        $replaceExpr = explode('|', $replaceExpr);
        $replaceChar = explode('|', $replaceChar);

        foreach ($matchExpr as $indx => $match) {
            if (isset($replaceExpr[$indx]) && isset($replaceChar[$indx]) && $match) {
                $expressions[] = array(
                    'match' => $match,
                    'replace' => $replaceExpr[$indx],
                    'char' => $replaceChar[$indx],
                );
            }
        }

        return $expressions;
    }

    public function isMultiStoreResultsEnabled()
    {
        return (bool) Mage::getStoreConfig('searchsphinx/multistore/enabled');
    }

    public function getEnabledMultiStores()
    {
        return explode(',', Mage::getStoreConfig('searchsphinx/multistore/stores'));
    }

    public function isRelatedTermsEnabled()
    {
        return (bool) Mage::getStoreConfig('searchsphinx/advanced/related_terms');
    }

    public function isRedirectEnabled()
    {
        return (bool) Mage::getStoreConfig('searchsphinx/multistore/redirect');
    }

    public function isSearchOn404Enabled()
    {
        return (bool) Mage::getStoreConfig('searchsphinx/noroute/enabled');
    }
}
