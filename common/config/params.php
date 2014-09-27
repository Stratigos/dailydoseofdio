<?php
return [
    'adminEmail'                    => 'admin@example.com',
    'supportEmail'                  => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'isBackend'                     => FALSE,
    'imageDomain'                   => '',
    'uploadBaseDir'                 => '',
    's3Bucket'                      => '',
    'imageSizes'				    => [
    	'blogger' => [
    		'75x75'   => ['height' => 75, 'width' => 75, 'quality' => 80],
    		'200x200' => ['height' => 75, 'width' => 75, 'quality' => 80],
    		'500x500' => ['height' => 75, 'width' => 75, 'quality' => 80]
    	]
    ]
];
