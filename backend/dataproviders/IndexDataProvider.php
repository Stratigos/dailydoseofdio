<?php
/*****************************************************************************
* Backend DataProvider for Controller actionIndex() routines, or those where
*	a paginated index of a data model's records are displayed.
******************************************************************************/
namespace backend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class IndexDataProvider extends ActiveDataProvider
{
    public function init()
    {
        parent::init();
        $this->pagination->defaultPageSize = 10;
        $this->pagination->pageSizeParam   = FALSE; // simplifies urls / query strings
    }
}
