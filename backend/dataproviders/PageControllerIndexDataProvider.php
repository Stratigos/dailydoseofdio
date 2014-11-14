<?php
/*************************************************
* DataProvider for PageController::actionIndex()
*  Selects paginated list of Page instances.
**************************************************/
namespace backend\dataproviders;

use common\models\Page;

class PageControllerIndexDataProvider extends IndexDataProvider
{
    public function init()
    {
        parent::init();
        $this->query = Page::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC]);
    }
}
