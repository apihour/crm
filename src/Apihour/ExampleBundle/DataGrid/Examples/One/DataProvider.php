<?php

namespace Apihour\ExampleBundle\DataGrid\Examples\One;

use Tutto\DataGridBundle\DataGrid\DataProvider\ArrayDataProvider;
use Tutto\DataGridBundle\DataGrid\DataProvider\DataProviderInterface;

/**
 * Class DataProvider
 * @package Apihour\ExampleBundle\DataGrid\Examples\One
 */
class DataProvider extends ArrayDataProvider {
    public function __construct() {
        $results = [
            [
                'id' => 1,
                'name' => 'Krzysztof',
                'surname' => 'Januś',
                'email'   => 'fluke.kuczwa@gmail.com',
                'phone'   => '(14) 633 31 37',
                'accounts' => [
                    [
                        'id' => 1,
                        'name' => 'Konto GOLD'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Konto PREMIUM'
                    ]
                ]
            ],
            [
                'id' => 2,
                'name' => 'Krzysztof',
                'surname' => 'Januś',
                'email'   => 'fluke@gmail.com',
                'phone'   => '(14) 633 31 37',
                'accounts' => [
                    [
                        'id' => 3,
                        'name' => 'Konto SILVER'
                    ],
                    [
                        'id' => 4,
                        'name' => 'Konto FREE'
                    ]
                ]
            ]
        ];

        parent::__construct($results);
    }

}