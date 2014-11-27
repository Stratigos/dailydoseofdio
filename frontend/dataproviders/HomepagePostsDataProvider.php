<?php
/*************************************************
* Selects pages of Posts for index vertical
**************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Post;

class HomepagePostsDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->defaultPageSize = 10;
        $this->pagination->pageSizeParam   = FALSE;
        $this->query = Post::find()->publishedDesc()->with('blogger');
    }
}
