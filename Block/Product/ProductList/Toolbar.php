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

namespace Magenuts\AdvancedSorting\Block\Product\ProductList;

/**
 * Product list toolbar
 */
class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{

    /**
    * @var string
    */
    protected $_template = 'Magento_Catalog::product/list/toolbar.phtml'; 
    /**
     * Set collection to pager
     *
     * @param \Magento\Framework\Data\Collection $collection
     * @return $this
     */
    
    public function setCollection($collection)
    {
        $this->_collection = $collection;

        $this->_collection->setCurPage($this->getCurrentPage());

        $limit = (int) $this->getLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }
        if ($this->getCurrentOrder()) {
            if ($this->getCurrentOrder() == 'mostviewed') {
                if(!strpos((string)$this->_collection->getSelect(), 'report') > 0) {
                    $this->_collection->getSelect()
                        ->joinLeft(
                            [
                                'report' => $this->_collection
                                                ->getTable('report_event')
                            ],
                                "(report.object_id = e.entity_id "
                                . "AND (report.event_type_id = 1))",
                                    [
                                        'view' => "count(report.event_id)"
                                    ]
                            )->group("e.entity_id")
                            ->order('view ' . $this->getCurrentDirectionReverse());
                }
            } elseif ($this->getCurrentOrder() == 'bestseller') {
                $this->_collection->getSelect()
                        ->joinLeft(
                                'sales_order_item',
                                'e.entity_id = sales_order_item.product_id',
                                'SUM(sales_order_item.qty_ordered) AS ordered_qty'
                            )
                ->group('e.entity_id')
                ->order('ordered_qty ' . $this->getCurrentDirectionReverse());
            } elseif ($this->getCurrentOrder() == 'rating') {
                if(!strpos((string)$this->_collection->getSelect(), 'rating_summary') > 0) {
                    $this->_collection
                            ->joinField(
                                    'rating_summary', 'review_entity_summary',
                                    'rating_summary', 'entity_pk_value=entity_id', 
                                    [
                                        'entity_type' => 1, 
                                        'store_id' => $this->_storeManager
                                                        ->getStore()->getId()
                                    ],
                                    'left'
                                )
                            ->setOrder(
                                    'rating_summary',
                                    $this->getCurrentDirectionReverse()
                                    );
                }
            } elseif ($this->getCurrentOrder() == 'stock') {
                 $this->_collection->getSelect()
                        ->joinLeft(
                                'cataloginventory_stock_item',
                                'e.entity_id = cataloginventory_stock_item.product_id',
                                'cataloginventory_stock_item.qty AS quantity'
                        )
                    ->group('e.entity_id')
                    ->order('quantity ' . $this->getCurrentDirectionReverse());
            } elseif ($this->getCurrentOrder() == 'reviewcount') {
                if(!strpos((string)$this->_collection->getSelect(), 'reviews_count') > 0) {
                    $this->_collection
                            ->joinField(
                                    'reviews_count', 'review_entity_summary',
                                    'reviews_count','entity_pk_value=entity_id', 
                                    [
                                        'entity_type' => 1,
                                        'store_id' => $this->_storeManager
                                                    ->getStore()->getId()
                                    ],
                                    'left'
                                )
                            ->setOrder(
                                    'reviews_count',
                                    $this->getCurrentDirectionReverse()
                                    );
                }
            } elseif ($this->getCurrentOrder() == 'wishlist') {
                if(!strpos((string)$this->_collection->getSelect(), 'wishlist') > 0) {
                    $this->_collection->getSelect()
                            ->joinLeft(
                                    [
                                        'wishlist' => $this->_collection
                                                        ->getTable('wishlist_item')
                                    ],
                                    "wishlist.product_id = e.entity_id",
                                    [
                                        'wishlistcount' =>
                                        "count(wishlist.wishlist_id)"
                                    ]
                            )
                    ->group("e.entity_id")
                    ->order('wishlistcount ' . $this->getCurrentDirectionReverse());
                }
            } elseif ($this->getCurrentOrder() == 'biggestsaving') {
                    $biggestsaving = "discount_percent_value_".rand(1,1000);
                    $this->_collection
                            ->addExpressionAttributeToSelect(
                                    $biggestsaving,
                                    '(({{price}} - final_price) / {{price}})',
                                    ['price']
                            )
                            ->setOrder(
                                    ['price'],
                                    $this->getCurrentDirectionReverse()
                            );
                    return $this->_collection;
            } elseif ($this->getCurrentOrder() == 'lastordered') {
                $this->_collection->getSelect()
                        ->joinLeft(
                                'sales_order_item',
                                'e.entity_id = sales_order_item.product_id',
                                'sales_order_item.created_at AS lastorder'
                        )
                    ->group('e.entity_id')
                    ->order('lastorder ' . $this->getCurrentDirectionReverse());
            } elseif ($this->getCurrentOrder() == 'featured') {
                $this->_collection
                        ->addAttributeToFilter('featured', 1)
                        ->setOrder(
                                $this->getCurrentOrder(),
                                $this->getCurrentDirectionReverse()
                        );
                $this->_collection->getSelect()->orderRand();
            } elseif ($this->getCurrentOrder() == 'created_at') {
                $this->_collection
                        ->setOrder(
                                $this->getCurrentOrder(),
                                $this->getCurrentDirectionReverse()
                        );
            } else {
                $this->_collection
                        ->setOrder(
                                $this->getCurrentOrder(),
                                $this->getCurrentDirection()
                        );
            }
        }
        return $this->_collection;
    }

    public function getCurrentDirectionReverse()
    {
        if ($this->getCurrentDirection() == 'asc') {
            return 'desc';
        } elseif ($this->getCurrentDirection() == 'desc') {
            return 'asc';
        } else {
            return $this->getCurrentDirection();
        }
    }

}