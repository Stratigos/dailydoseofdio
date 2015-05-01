# DDoD - Daily Dose of Dio

[Yii2](https://github.com/yiisoft/yii2) Beta Advanced Application, which creates a CMS and resulting user-facing blog for discussing the awesome and enigmatic human being [Ronnie James Dio](http://ronniejamesdio.com/). The frontend features responsive design with a mobile friendly UI. The backend utilizes [Amazon S3 services](https://github.com/aws/aws-sdk-php) for image uploads, and several other community widgets, such as [DateTime](https://github.com/2amigos/yii2-date-time-picker-widget) pickers, [Selectize](https://github.com/2amigos/yii2-selectize-widget) tag attribution, and the [Summernote](https://github.com/zelenin/yii2-summernote-widget) editor (see the `composer.json` file for more info).

**...Under Construction...**

i) Add necessary environment params to webserver config (More potentially TBD)

Example params using Apache:

For "frontend" application:
````
  SetEnv YII_DEBUG 1
  SetEnv YII_ENV dev
  SetEnv IS_MANAGE 0
````

For "backend" application:

````
  SetEnv YII_DEBUG 1
  SetEnv YII_ENV dev
  SetEnv IS_MANAGE 1
  # AWS AUTH NECESSARY FOR IMAGE UPLOADS TO S3
  SetEnv AWS_ACCESS_KEY_ID YOUR-AWS-ACCESS-KEY
  SetEnv AWS_SECRET_ACCESS_KEY YOUR-AWS-SECRET-KEY
````

ii) Create a new database, and add the credentials to it to the appropriate config params file.

Example DB config, using MySQL: 
````
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=DBSCHEMA',
            'username' => 'DBUSER',
            'password' => 'DBPASS',
            'charset' => 'utf8',
        ] // ... additional components
    // ... additional configs
    ]
````

1) Use `composer update` to load vendor/ dir and external dependencies.

2) Use `php init` to initialize application.

3) Use `yii migrate` ( `php /path/to/this/app/yii migrate/up` ) to apply seed data and any schema migrations.  
  3i) Create alias for the `yii` command via: `alias yii='php /var/www/PATH-TO-DDOD-CHECKOUT/yii'`


### Copyleft

Copyright :copyright: 2014-2015 Todd Morningstar | [https:://github.com/stratigos](https:://github.com/stratigos)  
GPLv3 LISENCE - Please see [License File](LICENSE.md)  
