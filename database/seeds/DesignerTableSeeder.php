<?php

use App\Models\Designer;
use Illuminate\Database\Seeder;


class DesignerTableSeeder extends Seeder
{
    public function run()
    {
        Designer::create([
            'title' => 'لباس شب',
            'slug' => 'night dress'.rand(1, 10000),
            'parts' => [
                'S' => [
                    'fabric' => 'S',
                    'variations' => ['001', '004']
                ],
                'T' => [
                    'fabric' => 'T',
                    'variations' => ['001', '003', '004']
                ],
                'SK' => [
                    'fabric' => 'SK',
                    'variations' => ['001', '002']
                ]
            ],
            'cameras' => [
                'Front' => [
                    'layers' => [
                        ['S'],
                        ['T', 'S'],
                        ['SK', 'T']
                    ],
                    'fabrics' => [
                        [true],
                        [true, false],
                        [true, false]
                    ]
                ],
                'Back' => [
                    'layers' => [
                        ['S'],
                        ['T', 'S'],
                        ['SK', 'T']
                    ],
                    'fabrics' => [
                        [true],
                        [true, false],
                        [true, false]
                    ]
                ]
            ],
            'flags' => [
                'f0' => 'پارچه مخملی است',
                'f1' => 'پارچه مخملی ضروری نیست',
            ],
            'options' => [
                [
                    'label' => 'پیرهن',
                    'camera' => 'Front',
                    'options' => [
                        [
                            'label' => 'آستین',
                            'camera' => 'Front',
                            'values' => [
                                ['label' => 'کوتاه', 'key' => 'S', 'value' => '001', 'flagup' => 'f1'],
                                ['label' => 'بلند', 'key' => 'S', 'value' => '004', 'flag' => 'f0', 'flagdown' => 'f1'],
                            ]
                        ],
                        [
                            'label' => 'پارچه',
                            'camera' => 'Front',
                            'values' => [
                                ['label' => 'سبز', 'key' => 'S', 'fabric' => 'F001', 'flagdown' => 'f0', 'flag' => 'f1'],
                                ['label' => 'صورتی', 'key' => 'S', 'fabric' => 'F002', 'flagup' => 'f0'],
                            ]
                        ],
                    ]
                ],
                [
                    'label' => 'بدنه',
                    'camera' => 'Front',
                    'values' => [
                        ['label' => 'کوتاه', 'key' => 'T', 'value' => '001', 'fabric' => 'F001'],
                        ['label' => 'بلند', 'key' => 'T', 'value' => '003', 'fabric' => 'F002'],
                        ['label' => 'متوسط', 'key' => 'T', 'value' => '004', 'fabric' => 'F001'],
                    ]
                ],
                [
                    'label' => 'دامن',
                    'camera' => 'Front',
                    'values' => [
                        ['label' => 'صورتی', 'key' => 'SK', 'value' => '001', 'fabric' => 'F002'],
                        ['label' => 'سبز', 'key' => 'SK', 'value' => '002', 'fabric' => 'F001']
                    ]
                ]
            ],
        ]);
    }
}
