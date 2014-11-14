<?php
/***************************************************
* DataProvider for BloggerController::actionIndex()
*  Selects paginated list of Blogger instances.
****************************************************/
namespace backend\dataproviders;

use common\models\Blogger;

class BloggerControllerIndexDataProvider extends IndexDataProvider
{
    public function init()
    {
        parent::init();
        $this->query = Blogger::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC]);
    }
}
