<?php
/***************************************************
* DataProvider for DioSiteController::actionIndex()
*  Selects paginated list of DioSite instances.
****************************************************/
namespace backend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\DioSite;

class DiositeControllerIndexDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->pageSize = 10;
        $this->query                = DioSite::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC]);
    }
}
