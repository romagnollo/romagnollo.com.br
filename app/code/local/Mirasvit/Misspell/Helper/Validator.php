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
 * @package   mirasvit/extension_misspell
 * @version   1.2.11
 * @copyright Copyright (C) 2018 Mirasvit (https://mirasvit.com/)
 */



class Mirasvit_Misspell_Helper_Validator extends Mirasvit_MstCore_Helper_Validator_Abstract
{
    public function testTablesExists()
    {
        $result = self::SUCCESS;
        $title = 'Search Spell-Correction: Required tables are exists';
        $description = array();

        $tables = array(
            'misspell/misspell',
            'misspell/misspell_suggest',
        );

        foreach ($tables as $table) {
            if (!$this->dbTableExists($table)) {
                $description[] = "Table '$table' not exists";
                $result = self::FAILED;
            }
        }

        return array($result, $title, $description);
    }

    public function testReindexIsCompleted()
    {
        $result = self::SUCCESS;
        $title = 'Search Spell-Correction: index is valid';
        $description = '';

        if ($this->dbTableIsEmpty('misspell/misspell')) {
            $result = self::FAILED;
            $description = 'Please run reindex at System / Configuration / Search Spell-Correction';
        }

        return array($result, $title, $description);
    }
}
