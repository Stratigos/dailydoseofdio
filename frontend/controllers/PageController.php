<?php
/******************************************************************
* Actions to load Pages - content datatype for storing non dynamic 
*   page content (/about, /contact, etc)
*******************************************************************/
namespace frontend\controllers;

use common\models\Page;
use yii\web\HttpException;

class PageController extends FrontendController
{
    /**
     * Load and display a Page
     * @return VOID
     */
    public function actionPage($shortname)
    {
        $page = Page::find()->where([
            'deleted_at' => 0,
            'shortname'  => $shortname
        ])->one();

        if (!$page) {
            throw new HttpException(404, 'Page aint found.');
        }

        return $this->render('page', ['page' => $page]);
    }
}
