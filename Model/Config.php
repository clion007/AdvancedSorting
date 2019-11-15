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

namespace Magenuts\AdvancedSorting\Model;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 
 
 */
class Config extends \Magento\Catalog\Model\Config
{

    /**
     * Retrieve Attributes Used for Sort by as array
     * key = code, value = name
     *
     * @return array
     */
    public function getAttributeUsedForSortByArray()
    {
        $options = ['position' => __('Position')];
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
                    $options['mostviewed'] = 'Most Viewed';
                }
                if (in_array('4', $sortingOptions)) {
                    $options['bestseller'] = 'Best Seller';
                }
                if (in_array('5', $sortingOptions)) {
                    $options['rating'] = 'Rating';
                }
                if (in_array('6', $sortingOptions)) {
                    $options['reviewcount'] = 'Reviews Count';
                }
                if (in_array('7', $sortingOptions)) {
                    $options['wishlist'] = 'Wishlist';
                }
                if (in_array('8', $sortingOptions)) {
                    $options['biggestsaving'] = 'Biggest Saving';
                }
                if (in_array('9', $sortingOptions)) {
                    $options['lastordered'] = 'Last Ordered';
                }
                if (in_array('10', $sortingOptions)) {
                    $options['stock'] = 'Quantity / Stock';
                }
            }
        }
        foreach ($this->getAttributesUsedForSortBy() as $attribute) {
            $options[$attribute->getAttributeCode()] = $attribute
                                                        ->getStoreLabel();
        }
        return $options;
    }

}