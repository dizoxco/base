<?php

return [

    'payment' => [
        'pos' => [
            'key' => 'pos',
            'description' => 'پرداخت در محل'
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
