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

    public $titleCssClass = 'portlet-title text-center';

    public $htmlOptions = ['class' => 'portlet well'];

    /**
     * Displays the Advertisement
     */
    protected function renderContent()
    {
        $adContent = Html::beginTag('p');
            $adContent .= Html::img(
                'http://www.computerhowtoguide.com/wp-content/uploads/2012/08/annoying-ad.jpg',
                ['class' => 'img-responsive center-block']
            );
        $adContent .= Html::endTag('p');

        echo $adContent;

        return;
    } 
}
