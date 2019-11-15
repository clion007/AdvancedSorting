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

namespace Magenuts\AdvancedSorting\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;

class UpgradeData implements UpgradeDataInterface
{

    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $_eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            /**
             * Add attributes to the eav/attribute
             */
            $eavSetup->updateAttribute(
                    \Magento\Catalog\Model\Product::ENTITY,
                    'created_at',
                    'frontend_label',
                    'Date'
            );
            $eavSetup->updateAttribute(
                    \Magento\Catalog\Model\Product::ENTITY,
                    'created_at',
                    'used_for_sort_by',
                    true
            );
            $eavSetup->addAttribute(
                    \Magento\Catalog\Model\Product::ENTITY, 'featured', [
                'group' => 'General',
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Featured',
                'input' => 'boolean',
                'class' => '',
                'source' => '',
                'global' => Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
                'used_for_sort_by' => true,
                'unique' => false,
                'apply_to' => 'simple,configurable,virtual,bundle,downloadable'
                    ]
            );
        }
    }

}
