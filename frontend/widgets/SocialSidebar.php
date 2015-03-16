<?php
/************************************************
* Renders list of social media tools and widgets
*************************************************/
namespace frontend\widgets;

use frontend\widgets\Portlet;
use yii\helpers\Html;

class SocialSidebar extends Portlet
{
    public $title = 'Connect with Social Media';

    public $htmlOptions = ['class' => 'portlet well'];

    /**
     * Displays the Social Media Sidebar Links
     */
    protected function renderContent()
    {
        $socialContent = Html::beginTag('p');
            $socialContent .= 'Pile of Twatter, Facesmut, and Instaglam links here.';
        $socialContent .= Html::endTag('p');

        echo $socialContent;

        return;
    } 
}
