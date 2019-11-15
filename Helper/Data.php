<?php
/**
 * Magenuts Pvt Ltd.
 * Magenuts Advanced Sorting Extension
 * 
 * @category   Magenuts
 * @package    Magenuts_AdvancedSorting
 * @copyright  Copyright © 2019 Magenuts (https://www.magenuts.com)
 * @license    https://www.magenuts.com/magento-extension-license.txt/
 */
namespace Magenuts\AdvancedSorting\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     *  Get configuration settings value
     */
    public function getConfigValue($value = '')
    {
        return $this->scopeConfig->getValue(
                $value,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
    }

}