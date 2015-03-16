<?php
/*********************************************************
* Renders a block of text for displaying a Quote
*   TODO: Add cache to store selected Quote for 1 day
**********************************************************/
namespace frontend\widgets;

use common\models\Post;
use frontend\widgets\Portlet;
use yii\helpers\Html;

class DailyQuotePortlet extends Portlet
{
    public $title = 'Daily Dram';

    public $htmlOptions = ['class' => 'portlet well'];

    /**
     * Displays the Quote
     */
    protected function renderContent()
    {
        if ($quotePost = Post::find()->published()->joinWith('quote', true, 'RIGHT JOIN')->orderBy('RAND()')->one()) {
            $quotePortletContent = Html::beginTag('p');
                $quotePortletContent .= Html::tag('p', $quotePost->quote->body);
                $quotePortletContent .= Html::tag(
                    'p',
                    Html::tag(
                        'em',
                        Html::a($quotePost->quote->source, $quotePost->url)
                    )
                );
            $quotePortletContent .= Html::endTag('p');

            echo $quotePortletContent;
        }

        return;
    } 
}
