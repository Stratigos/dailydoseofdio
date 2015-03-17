<?php
/*********************************************************
* Renders a portlet displaying the most recent Dose
**********************************************************/
namespace frontend\widgets;

use common\models\Post;
use frontend\widgets\Portlet;
use yii\helpers\Html;

class DailyDosePortlet extends Portlet
{
    public $title = 'Daily Dose';

    public $htmlOptions = ['class' => 'portlet well text-center'];

    /**
     * Displays the Quote
     */
    protected function renderContent()
    {
        if ($dailyDose = Post::find()->publishedDesc()->one()) {
            $imgSrc             = $dailyDose->image ? $dailyDose->image : 'http://placehold.it/250x155';
            $dosePortletContent = Html::beginTag('p');
                $dosePortletContent .= Html::a(Html::encode($dailyDose->title), $dailyDose->url);
                $dosePortletContent .= Html::tag('br');
                $dosePortletContent .= Html::a(
                    Html::img(
                        $imgSrc,
                        [
                            'height' => 80,
                            'width' => 144
                        ]
                    ),
                    $dailyDose->url
                );
            $dosePortletContent .= Html::endTag('p');

            echo $dosePortletContent;
        }

        return;
    } 
}
