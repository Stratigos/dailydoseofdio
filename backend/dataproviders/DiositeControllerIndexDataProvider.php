<?php
/***************************************************
* DataProvider for DioSiteController::actionIndex()
*  Selects paginated list of DioSite instances.
****************************************************/
namespace backend\dataproviders;

use common\models\DioSite;

class DiositeControllerIndexDataProvider extends IndexDataProvider
{
    public function init()
    {
        parent::init();
        $this->query = DioSite::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC]);
    }
}
