<?php
return [
    'defaultTitle'                  => 'Daily Dose of Dio',
    'adminEmail'                    => 'admin@example.com',
    'supportEmail'                  => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'isBackend'                     => false,
    'imageDomain'                   => '',
    'uploadBaseDir'                 => '',
    's3Bucket'                      => '',
    'imageSizes'                    => [
        'blog' => [
            '75x75'   => ['width' => 75,  'height' => 75,  'quality' => 90],
            '200x200' => ['width' => 200, 'height' => 200, 'quality' => 90]
        ],
        'blogger' => [
            '75x75'   => ['width' => 75,  'height' => 75,  'quality' => 90],
            '200x200' => ['width' => 200, 'height' => 200, 'quality' => 90],
            '500x500' => ['width' => 500, 'height' => 500, 'quality' => 90]
        ],
        'post' => [
            '75x75'   => ['width' => 75,  'height' => 75,  'quality' => 90],
            '250x155' => ['width' => 250, 'height' => 155, 'quality' => 90]
        ],
        'promotedpost' => [
            '75x75'   => ['width' => 75,  'height' => 75,  'quality' => 90],
            '250x155' => ['width' => 250, 'height' => 155, 'quality' => 90]
        ]
    ]
];
