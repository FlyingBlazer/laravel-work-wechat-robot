<?php

return [
    'default' => env('WORK_WECHAT_ROBOT_DEFAULT', 'default'),
    'async' => env('WORK_WECHAT_ROBOT_ASYNC', true),
    'queue' => env('WORK_WECHAT_ROBOT_QUEUE', 'default'),

    'clients' => [
        'default' => env('WORK_WECHAT_ROBOT_WEBHOOK'),
    ]
];
