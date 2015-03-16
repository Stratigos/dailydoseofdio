<?php
/****************************************
* Renders a sidebar ad (i.e., 300x250)
*****************************************/
namespace frontend\widgets;

use frontend\widgets\Portlet;
use yii\helpers\Html;

class AdSidebar extends Portlet
{
    public $title = 'Sidebar Ad';

    public $htmlOptions = ['class' => 'portlet well'];

    /**
     * Displays the Advertisement
     */
    protected function renderContent()
    {
        $adContent = Html::beginTag('p');
            $adContent .= 'ANNOYING AD HERE !';
        $adContent .= Html::endTag('p');

        echo $adContent;

        return;
    } 
}
