<?php
/*******************************************
* Category indices/verticals
********************************************/
namespace frontend\controllers;

use common\models\Category;
use frontend\dataproviders\CategoriesDataProvider;
use frontend\dataproviders\CategoryPostsDataProvider;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;
use yii\web\HttpException;

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
    public function actionCategory($shortname)
    {
        if(!($category = Category::find()->published()->andWhere(['shortname' => $shortname])->one())) {
            throw new HttpException(404, "YOUR MOM");
        }
        $catPostsDP = new CategoryPostsDataProvider(['category_id' => $category->id]);

        return $this->render(
            'category',
            [
                'category' => $category,
                'postsDP'  => $catPostsDP
            ]
        );
    }

}
