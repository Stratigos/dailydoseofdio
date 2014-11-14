<?php
/*************************************************
* DataProvider for BlogController::actionIndex()
*  Selects paginated list of Blog instances.
**************************************************/
namespace backend\dataproviders;

use common\models\Blog;

class BlogControllerIndexDataProvider extends IndexDataProvider
{
    public function init()
    {
        parent::init();
        $this->query = Blog::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC]);
    }
}
