<?php

return [
    'media' =>  [
        'user'  =>  [
            'avatar'    =>  'users_avatar',
        ],
        'post'  =>  [
            'banner'    =>  'posts_banner',
            'attach'    =>  'posts_attach',
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
            'organ' => 0
        ]
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
