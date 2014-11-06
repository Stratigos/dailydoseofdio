<?php
/***************************************************
* DataProvider for CategoryController::actionIndex()
*  Selects paginated list of Category instances.
****************************************************/
namespace backend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Category;

class CategoryControllerIndexDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->pageSize = 10;
        $this->query                = Category::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC]);
    }
}
