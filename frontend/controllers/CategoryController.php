<?php
/**
* UNDER CONSTRUCTION
**/
namespace frontend\controllers;

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
     * DOING THINGS WITH COMPUTERS
     * @todo document this, h'aint?
     * @return VOID
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                //'posts'       => $postsDP->getModels(),
                //'pagination'  => $postsDP->pagination
            ]
        );
    }

}
