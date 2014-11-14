<?php
/***************************************************
* DataProvider for PostController::actionIndex()
*  Selects paginated list of Post instances.
****************************************************/
namespace backend\dataproviders;

use common\models\Post;

class PostControllerIndexDataProvider extends IndexDataProvider
{
    public function init()
    {
        parent::init();
        $this->query = Post::find()->where(['deleted_at' => 0])->orderBy(
        	[
                'published_at' => SORT_DESC,
                'created_at'   => SORT_DESC
            ]
        );
    }
}
