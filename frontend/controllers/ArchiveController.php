<?php
/*******************************************
* Dose Archives
*  lists of Posts (index by date, etc)
********************************************/
namespace frontend\controllers;

use frontend\controllers\FrontendController;
use frontend\dataproviders\PostsDataProvider;
use yii\web\HttpException;

class ArchiveController extends FrontendController
{
    /**
     * Produce list of Category names and URLs
     * @return VOID
     */
    public function actionIndex()
    {
        return $this->render('index', ['postsDP' => new PostsDataProvider()]);
    }
}