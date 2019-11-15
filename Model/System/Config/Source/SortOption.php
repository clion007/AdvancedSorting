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
namespace Magenuts\AdvancedSorting\Model\System\Config\Source;

class SortOption implements \Magento\Framework\Option\ArrayInterface
{
    const SORT_DATE = 1;
    const SORT_FEATURED = 2;
    const SORT_MOSTVIEWED = 3;
    const SORT_BESTSELLER = 4;
    const SORT_RATING = 5;
    const SORT_REVIEWCOUNT = 6;
    const SORT_WISHLIST = 7;
    const SORT_BIGGESTSAVING = 8;
    const SORT_LASTORDERED = 9;
    const SORT_STOCK = 10;

    /**
     * @var \Magento\Framework\Option\ArrayInterface
     */
    protected $_options;

    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = [];
            $this->_options[] = [
                'label' => 'Date',
                'value' => self::SORT_DATE
                    ];
            $this->_options[] = [
                'label' => 'Featured',
                'value' => self::SORT_FEATURED
                    ];
            $this->_options[] = [
                'label' => 'Most Viewed',
                'value' => self::SORT_MOSTVIEWED
                    ];
            $this->_options[] = [
                'label' => 'Best Seller',
                'value' => self::SORT_BESTSELLER
                    ];
            $this->_options[] = [
                'label' => 'Rating',
                'value' => self::SORT_RATING
                    ];
            $this->_options[] = [
                'label' => 'Reviews Count',
                'value' => self::SORT_REVIEWCOUNT
                    ];
            $this->_options[] = [
                'label' => 'Wishlist',
                'value' => self::SORT_WISHLIST
                    ];
            $this->_options[] = [
                'label' => 'Biggest Saving',
                'value' => self::SORT_BIGGESTSAVING
                    ];
            $this->_options[] = [
                'label' => 'Last Ordered',
                'value' => self::SORT_LASTORDERED
                    ];
            $this->_options[] = [
                'label' => 'Quantity / Stock',
                'value' => self::SORT_STOCK
                    ];
            $options = $this->_options;
            return $options;
        }
    }

}