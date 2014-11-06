<?php
/***************************************************
* DataProvider for BloggerController::actionIndex()
*  Selects paginated list of Blogger instances.
****************************************************/
namespace backend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Blogger;

class BloggerControllerIndexDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->pageSize = 10;
        $this->query                = Blogger::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC]);
    }
}
