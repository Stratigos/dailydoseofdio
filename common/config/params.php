<?php
return [
    'adminEmail'                    => 'admin@example.com',
    'supportEmail'                  => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'isBackend'                     => FALSE,
    'imageDomain'                   => '',
    'uploadBaseDir'                 => '',
    's3Bucket'                      => '',
    'imageSizes'                    => [
        'blog' => [
            '75x75'   => ['width' => 75,  'height' => 75,  'quality' => 80],
            '200x200' => ['width' => 200, 'height' => 200, 'quality' => 80]
        ],
        'blogger' => [
            '75x75'   => ['width' => 75,  'height' => 75,  'quality' => 80],
            '200x200' => ['width' => 200, 'height' => 200, 'quality' => 80],
            '500x500' => ['width' => 500, 'height' => 500, 'quality' => 80]
        ]
    ]
];
