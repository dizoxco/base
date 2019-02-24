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
                    'fabric' => 'T',
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
                ['id' => 0, 'description' => 'پارچه گلی']
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
                                ['label' => 'کوتاه', 'key' => 'S', 'value' => '001'],
                                ['label' => 'بلند', 'key' => 'S', 'value' => '004'],
                            ]
                        ],
                        [
                            'label' => 'یقه',
                            'camera' => 'Front',
                            'values' => [
                                ['label' => 'کوتاه', 'key' => 'T', 'value' => '001'],
                                ['label' => 'بلند', 'key' => 'T', 'value' => '003'],
                                ['label' => 'متوسط', 'key' => 'T', 'value' => '004'],
                            ]
                        ],
                        [
                            'label' => 'پارچه',
                            'camera' => 'Front',
                            'values' => [
                                ['label' => 'صورتی', 'key' => 'T', 'fabric' => 'F001'],
                                ['label' => 'سبز', 'key' => 'T', 'fabric' => 'F002'],
                            ]
                        ],
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
