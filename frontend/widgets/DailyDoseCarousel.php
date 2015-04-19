<?php
/************************************************************************
* Renders a Bootstrap Carousel with PromotedPosts as content.
* @see http://getbootstrap.com/javascript/#carousel
* @see http://www.yiiframework.com/doc-2.0/yii-bootstrap-carousel.html
* @see common/models/PromotedPost
*************************************************************************/
namespace frontend\widgets;

use frontend\assets\DailyDoseCarouselAsset;
use frontend\dataproviders\PromotedPostsDataProvider;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\helpers\StringHelper;

class DailyDoseCarousel extends Carousel {

    /**
     * @var inheritdoc
     */
    public $controls = [
        '<i class="glyphicon glyphicon-hand-left"></i>',  // left
        '<i class="glyphicon glyphicon-hand-right"></i>'  // right
    ];

    /**
     * @var $dataProvider ActiveDataProvider
     */
    public $dataProvider;

    /**
     * @var $summaryLength Int
     *  Length of each Carousel item's summary, within the caption.
     */
    public $summaryLength = 150;


    /**
     * Selects default DataProvider (if none passed into widget() call),
     *  then configures Carousel widget with DP data (i.e., PromotedPosts).
     * @inheritdoc
     */
    public function init()
    {
        if (!isset($this->dataProvider)) {
            $this->dataProvider = new PromotedPostsDataProvider;
        }
        if ($promos = $this->dataProvider->getModels()) {
            foreach ($promos as $promo) {
                $this->items[] = [
                    'content' => Html::img($promo->getImage()),
                    'caption' => '<div class="well">' . Html::a(
                        Html::tag('h4', StringHelper::truncateWords($promo->post->title, 5, '&hellip;'))
                        . Html::tag('p', $promo->getSummary($this->summaryLength)),
                        $promo->post->url
                    ) . "</div>"
                ];
            }
            $this->registerClientScript();
        }
        parent::init();

    }

    /**
     * adds CSS/JS files for this widget
     */
    public function registerClientScript()
    {
        DailyDoseCarouselAsset::register($this->getView());
    }
}
