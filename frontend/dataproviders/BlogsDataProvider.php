<?php
/****************************************************
* Selects all Blog records for display in a list
*****************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Blog;

class BlogsDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->pageSizeParam = false;
        $this->query 					 = Blog::find()->publishedRank();
    }
}
