<?php
/**********************************************************
* Asset bundler for DuckDuckGoSearchPortlet widget
* @see frontend/widgets/DuckDuckGoSearchPortlet.php;
***********************************************************/
namespace frontend\assets;

use yii\web\AssetBundle;

class DuckDuckSearchAsset extends AssetBundle
{
    public $baseUrl = '@web/css/widgets';

    public $depends = ['frontend\assets\AppAsset'];

    public function init()
    {
        $this->css[] = 'duckduckgosearchportlet.css';
    }
}
