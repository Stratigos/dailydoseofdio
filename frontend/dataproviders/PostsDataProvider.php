<?php
/*************************************************
* Selects pages of Posts for index vertical
**************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use common\models\Post;

class PostsDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->defaultPageSize = 10;
        $this->pagination->pageSizeParam   = false;
        $this->query      				   = Post::find()->publishedDesc()->with('blogger');
    }
}
