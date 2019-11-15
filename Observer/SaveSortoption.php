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

namespace Magenuts\AdvancedSorting\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveSortoption implements ObserverInterface
{

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\ObjectManagerInterface $interface
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\ObjectManagerInterface $interface,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_messageManager = $messageManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_objectManager = $interface;
    }

    /**
     * Log out user and redirect to new admin custom url
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $enableModule = $this->_scopeConfig
                ->getValue(
                        'advancedsortingsection/advancedsortinggroup/active',
                        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
        $sortingOption = explode(',', $this->_scopeConfig
                ->getValue(
                'advancedsortingsection/advancedsortinggroup/sorting_option',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
                );
        $attributeId = $this->_objectManager
                ->get('Magento\Eav\Model\ResourceModel\Entity\Attribute')
                ->getIdByCode('catalog_product', 'created_at');
        $featuredAttributeId = $this->_objectManager
                ->get('Magento\Eav\Model\ResourceModel\Entity\Attribute')
                ->getIdByCode('catalog_product', 'featured');
        
        if ($attributeId) {
            $attributeModel = $this->_objectManager
                    ->get('Magento\Catalog\Model\Entity\Attribute')
                    ->loadByCode('catalog_product', 'created_at');
            $sort = $attributeModel['used_for_sort_by'];
            $id = $attributeModel['attribute_id'];

            if (in_array('1', $sortingOption) && $enableModule) {
                $attributeModel->setUsedForSortBy(1);
                $attributeModel->save();
            } else {
                $attributeModel->setUsedForSortBy(0);
                $attributeModel->save();
            }
        }
        if ($featuredAttributeId) {
            $featuredAttributeModel = $this->_objectManager
                    ->get('Magento\Catalog\Model\Entity\Attribute')
                    ->loadByCode('catalog_product', 'featured');
            $sort = $featuredAttributeModel['used_for_sort_by'];
            $id = $featuredAttributeModel['attribute_id'];

            if (in_array('2', $sortingOption) && $enableModule) {
                $featuredAttributeModel->setUsedForSortBy(1);
                $featuredAttributeModel->save();
            } else {
                $featuredAttributeModel->setUsedForSortBy(0);
                $featuredAttributeModel->save();
            }
        }
    }

}