<?php
/*******************************************
* Category indices/verticals
********************************************/
namespace frontend\controllers;

use frontend\dataproviders\CategoriesDataProvider;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;

class CategoryController extends FrontendController
{
    // /**
    //  * @inheritdoc
    //  */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'only' => ['logout', 'signup'],
    //             'rules' => [
    //                 [
    //                     'actions' => ['signup'],
    //                     'allow' => true,
    //                     'roles' => ['?'],
    //                 ],
    //                 [
    //                     'actions' => ['logout'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'logout' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    /**
     * Produce list of Category names and URLs
     * @return VOID
     */
    public function actionIndex()
    {
        $categoryDP = new CategoriesDataProvider();
        return $this->render(
            'index',
            [
                'categories' => $categoryDP->getModels()
            ]
        );
    }

    /**
     * Lists all Posts in a Category
     * @return VOID
     */
    public function actionCategory()
    {
        // DO STUFF

        return $this->render('category');
    }

}
