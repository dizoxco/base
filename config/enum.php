<?php

return [

    'order' => [
        'status' => [ //
            'queue' => [
                'label' => 'در صف بررسی' ,
                'value' => 0
            ],
            'confirm' => [
                'label' => 'تایید سفارش' ,
                'value' => 1
            ],
            'prepare' => [
                'label' => 'آماده سازی سفارش' ,
                'value' => 2
            ],
            'await' => [
                'label' => 'در انتظار پرداخت' ,
                'value' => 3
            ],
            'sending' => [
                'label' => 'در حال ارسال' ,
                'value' => 4
            ],
            'delivered' => [
                'label' => 'تحویل مرسوله' ,
                'value' => 5
            ],
        ],
    ],
    'payment' => [
        'pos' => [
            'key' => 'pos',
            'description' => 'پرداخت در محل',
        ],
        'zarinpal' => [
            'key' => 'zarinpal',
            'description' => 'زرین پال',
        ],
    ],

    'media' =>  [
        'user'  =>  [
            'avatar'    =>  'users_avatar',
        ],
        'post'  =>  [
            'banner'    =>  'posts_banner',
            'attach'    =>  'posts_attach',
        ],
        'product'  =>  [
            'banner'    =>  'products_banner',
            'gallery'   =>  'products_gallery',
        ],
        'business'  =>  [
            'logo'    =>  'business_logos',
        ],
    ],

    'system'    =>  [
        'request'   =>  [
            'xhr'   =>  'XMLHttpRequest',
        ],
        'response'  =>  [
            'json'  =>  'application/vnd.api+json',
            'unauthenticated'   =>  ['message'  =>  'Unauthenticated.'],
        ],
    ],

    'chat'  =>  [
        'type'  =>  [
            'ticket'    =>  1,
            'chat'      =>  2,
        ],
        'responder' => [
            'organ' => 0,
        ],
    ],

    'ticket'    =>  [
        'category'  =>  [
            1   =>  'problem',
            2   =>  'warning',
            3   =>  'danger',
            4   =>  'critical',
        ],
    ],
];
