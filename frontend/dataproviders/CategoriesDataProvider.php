<?php
/****************************************************
* Selects all Category records for display in a list
*****************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Category;

class CategoriesDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->defaultPageSize = 50;
        $this->pagination->pageSizeParam   = FALSE;
        $this->query = Category::find()->publishedDesc();
    }
}
