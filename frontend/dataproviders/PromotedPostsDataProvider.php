<?php
/******************************************************************
* Selects all published PromotedPosts for display on the homepage.
*   Typically selected for display in rotating carousel.
*******************************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use common\models\Post;

class PromotedPostsDataProvider extends ActiveDataProvider
{

    /**
     * @var $quantity Int
     *  Default number of PromotedPosts to select.
     */
    public $quantity = 5;

    /**
     * @var $carousel Boolean
     *  if TRUE (default), will disable pagination.
     *  if FALSE, will enable ActiveDataProvider $pagination module.
     */
    public $carousel = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->pagination = false; // disable pagination
        $this->query      = PromotedPost::find()->publishedRankDesc()->limit($this->quantity);
    }
}
