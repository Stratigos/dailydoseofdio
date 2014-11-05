<?php
/*************************************************
* DataProvider for PageController::actionIndex()
*  Selects paginated list of Page instances.
**************************************************/
namespace backend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Page;

class PageControllerIndexDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->pageSize = 10;
        $this->query                = Page::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC]);
    }
}
