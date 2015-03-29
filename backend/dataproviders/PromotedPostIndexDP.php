<?php
/********************************************************
* DataProvider for PromotedPostController::actionIndex()
*  Selects list of PromotedPosts set for site display.
*********************************************************/
namespace backend\dataproviders;

use common\models\PromotedPost;

class PromotedPostIndexDP extends IndexDataProvider
{
    public function init()
    {
        parent::init();
        $this->query = PromotedPost::find()->where(['deleted_at' => 0])->with('post')->orderBy(['rank' => SORT_ASC]);
    }
}
