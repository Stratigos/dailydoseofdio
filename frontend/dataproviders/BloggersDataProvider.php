<?php
/**********************************************************
* Selects all active Blogger records for display in a list
***********************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Blogger;

class BloggersDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->pageSizeParam = false;
        $this->query                     = Blogger::find()->publishedRank();
    }
}
