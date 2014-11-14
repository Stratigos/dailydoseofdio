<?php
/***************************************************
* DataProvider for CategoryController::actionIndex()
*  Selects paginated list of Category instances.
****************************************************/
namespace backend\dataproviders;

use common\models\Category;

class CategoryControllerIndexDataProvider extends IndexDataProvider
{
    public function init()
    {
        parent::init();
        $this->query = Category::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC]);
    }
}
