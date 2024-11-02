<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 30-10-2022
 */

namespace App\Constants;

use App\Lib\MiniCollection;

class Product
{
    /**
     * Product queryable data in collection
     *
     * @return MiniCollection
     */
    public static function queryCollection()
    {
        return new MiniCollection(self::queryArray(), true);
    }

    /**
     * Product queryable data array
     *
     * @return array
     */
    public static function queryArray()
    {
        return
            [
                'query' => [
                    'brand' => [
                        'name' => __('Brand'),
                        'operations' => [
                            'in' => [
                                'name' => __('IS'),
                                'value' => 'in',
                                'input' => [
                                    'type' => 'select',
                                    'placeholder' => __('Select Brands'),
                                    'class' => 'brand',
                                    'ajax' => true,
                                    'multiple' => 'multiple',
                                ],
                            ],
                            'notIn' => [
                                'name' => __('NOT'),
                                'value' => 'notIn',
                                'input' => [
                                    'type' => 'select',
                                    'placeholder' => __('Select Brand'),
                                    'class' => 'brand',
                                    'ajax' => true,
                                    'multiple' => 'multiple',
                                ],
                            ],
                        ],
                    ],
                    'category' => [
                        'name' => 'Category',
                        'operations' => [
                            'in' => [
                                'name' => __('IS'),
                                'value' => 'in',
                                'input' => [
                                    'type' => 'select',
                                    'placeholder' => __('Select Categories'),
                                    'class' => 'category',
                                    'ajax' => true,
                                    'multiple' => 'multiple',
                                ],
                            ],
                            'notIn' => [
                                'name' => __('NOT'),
                                'value' => 'notIn',
                                'input' => [
                                    'type' => 'select',
                                    'placeholder' => __('Select Categories'),
                                    'class' => 'category',
                                    'ajax' => true,
                                    'multiple' => 'multiple',
                                ],
                            ],
                        ],
                    ],
                    'tag' => [
                        'name' => 'Tag',
                        'operations' => [
                            'in' => [
                                'name' => __('IS'),
                                'value' => 'in',
                                'input' => [
                                    'type' => 'select',
                                    'placeholder' => __('Select Tags'),
                                    'class' => 'tags',
                                    'ajax' => true,
                                    'multiple' => 'multiple',
                                ],
                            ],
                            'notIn' => [
                                'name' => __('NOT'),
                                'value' => 'notIn',
                                'input' => [
                                    'type' => 'select',
                                    'placeholder' => __('Select Tags'),
                                    'class' => 'tag',
                                    'ajax' => true,
                                    'multiple' => 'multiple',
                                ],
                            ],
                        ],
                    ],
                    'vendor' => [
                        'name' => __('Vendor'),
                        'operations' => [
                            'in' => [
                                'name' => __('IS'),
                                'value' => 'in',
                                'input' => [
                                    'type' => 'select',
                                    'placeholder' => __('Select Vendor'),
                                    'class' => 'brand',
                                    'ajax' => true,
                                    'multiple' => 'multiple',
                                ],
                            ],
                            'notIn' => [
                                'name' => __('NOT'),
                                'value' => 'notIn',
                                'input' => [
                                    'type' => 'select',
                                    'placeholder' => __('Select Vendor'),
                                    'class' => 'brand',
                                    'ajax' => true,
                                    'multiple' => 'multiple',
                                ],
                            ],
                        ],
                    ],
                    'featured' => [
                        'name' => __('Featured'),
                        'operations' => [
                            'is' => [
                                'name' => __('IS'),
                                'value' => 'is',
                                'input' => [
                                    'type' => 'select',
                                    'placeholder' => __('Featured'),
                                    'class' => 'featured',
                                    'ajax' => false,
                                    'multiple' => 'false',
                                    'options' => ['0' => __('False'), '1' => __('True')],
                                ],
                            ],
                        ],
                    ],
                    'createdAt' => [
                        'name' => 'Created At',
                        'operations' => [
                            'greaterThanEqual' => [
                                'name' => '>=',
                                'value' => 'greaterThanEqual',
                                'input' => [
                                    'type' => 'date',
                                    'placeholder' => __('Select Date'),
                                    'class' => 'createdAt',
                                ],
                            ],
                            'lessThanEqual' => [
                                'name' => '<=',
                                'value' => 'lessThanEqual',
                                'input' => [
                                    'type' => 'date',
                                    'placeholder' => __('Select Date'),
                                    'class' => 'createdAt',
                                ],
                            ],
                            'equal' => [
                                'name' => '==',
                                'value' => 'equal',
                                'input' => [
                                    'type' => 'date',
                                    'placeholder' => __('Select Date'),
                                    'class' => 'createdAt',
                                ],
                            ],
                        ],
                    ],
                ],
                'order' => [
                    'name' => ['name' => __('Product Title')],
                    'price' => ['name' => __('Product Price')],
                    'createdAt' => ['name' => __('Created At')],
                    'featured' => ['name' => __('Featured Date')],
                ],
            ];
    }
}
