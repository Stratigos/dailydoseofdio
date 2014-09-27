<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'image' => array(
            'class'  => 'yii\image\ImageDriver',
            'driver' => 'Imagick',  // GD or Imagick
        ),
    ],
];
