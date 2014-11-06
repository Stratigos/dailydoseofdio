<?php
/***************************************************
* DataProvider for PostController::actionIndex()
*  Selects paginated list of Post instances.
****************************************************/
namespace backend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Post;

class PostControllerIndexDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->pageSize = 10;
        $this->query                = Post::find()->where(['deleted_at' => 0])->orderBy(
        	[
                'published_at' => SORT_DESC,
                'created_at'   => SORT_DESC
            ]
        );
    }
}
