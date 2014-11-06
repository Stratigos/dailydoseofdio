<?php
/*************************************************
* DataProvider for BlogController::actionIndex()
*  Selects paginated list of Blog instances.
**************************************************/
namespace backend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Blog;

class BlogControllerIndexDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->pageSize = 10;
        $this->query                = Blog::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC]);
    }
}
