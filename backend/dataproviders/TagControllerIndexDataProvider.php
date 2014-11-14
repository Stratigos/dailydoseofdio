<?php
/***************************************************
* DataProvider for TagController::actionIndex()
*  Selects paginated list of Tag instances.
****************************************************/
namespace backend\dataproviders;

use common\models\Tag;

class TagControllerIndexDataProvider extends IndexDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->pageSize = 50;
        $this->query                = Tag::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC]);
    }
}
