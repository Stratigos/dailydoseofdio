<?php
/**********************************************************
* Asset bundler for DailyDoseCarousel widget
* @see frontend/widgets/DailyDoseCarousel.php;
***********************************************************/
namespace frontend\assets;

use yii\web\AssetBundle;

class DailyDoseCarouselAsset extends AssetBundle
{
    public $baseUrl = '@web/css/widgets';

    public $depends = ['frontend\assets\AppAsset'];

    public function init()
    {
        $this->css[] = 'dailydosecarousel.css';
        // @todo CREATE MINIFIED VERSION OF CSS AS DEMONSTRATED IN FOLLOWING COMMENT:
        // $this->css[] = YII_DEBUG ? 'css/somecssfile.css' : 'css/somecssfile.min.css';
        // $this->js[] = YII_DEBUG ? 'js/somejsfile.js' : 'js/somejsfile.min.js';
    }
}
