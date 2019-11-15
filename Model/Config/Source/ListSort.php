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

namespace Magenuts\AdvancedSorting\Model\Config\Source;

class ListSort extends \Magento\Catalog\Model\Config\Source\ListSort
{
    /**
     * Retrieve option values array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $options[] = ['label' => __('Position'), 'value' => 'position'];
        $helper = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Magenuts\AdvancedSorting\Helper\Data');
        $enableModule = $helper
                    ->getConfigValue(
                        'advancedsortingsection/advancedsortinggroup/active'
                    );
        $sortingOption = $helper
                ->getConfigValue(
                    'advancedsortingsection/advancedsortinggroup/sorting_option'
                    );
        if ($enableModule) {
            $sortingOptions = [];
            if ($sortingOption) {
                $sortingOptions = explode(',', $sortingOption);

                if (in_array('3', $sortingOptions)) {
                    $options[] = [
                        'label' => __('Most Viewed'),
                        'value' => 'mostviewed'
                        ];
                }
                if (in_array('4', $sortingOptions)) {
                    $options[] = [
                        'label' => __('Best Seller'),
                        'value' => 'bestseller'
                        ];
                }
                if (in_array('5', $sortingOptions)) {
                    $options[] = [
                        'label' => __('Rating'),
                        'value' => 'rating'
                        ];
                }
                if (in_array('6', $sortingOptions)) {
                    $options[] = [
                        'label' => __('Reviews Count'),
                        'value' => 'reviewcount'
                        ];
                }
                if (in_array('7', $sortingOptions)) {
                    $options[] = [
                        'label' => __('Wishlist'),
                        'value' => 'wishlist'
                        ];
                }
                if (in_array('8', $sortingOptions)) {
                    $options[] = [
                        'label' => __('Biggest Saving'),
                        'value' => 'biggestsaving'
                        ];
                }
                if (in_array('9', $sortingOptions)) {
                    $options[] = [
                        'label' => __('Last Ordered'),
                        'value' => 'lastordered'
                        ];
                }
                if (in_array('10', $sortingOptions)) {
                    $options[] = [
                        'label' => __('Quantity/Stock'),
                        'value' => 'stock'
                        ];
                }
            }
        }
        foreach ($this->_getCatalogConfig()
                ->getAttributesUsedForSortBy() as $attribute) {
            $options[] = [
                'label' => __($attribute['frontend_label']), 
                'value' => $attribute['attribute_code']
                    ];
        }
        return $options;
    }

}