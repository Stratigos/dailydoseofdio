<?php
/*********************************
* CRUD operations for Categories
**********************************/
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\dataproviders\CategoryControllerIndexDataProvider;
use common\models\Category;

class CategoryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow'   => true,
                        'roles'   => ['@']
                    ],
                    [
                        'actions' => ['index'],
                        'allow'   => true,
                        'roles'   => ['author']
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow'   => true,
                        'roles'   => ['admin']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new HttpException(403, "Invalid authorization for this action.");
                }
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    /**
     * render inventory as list of Categories
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'createCategoryUrl'      => Yii::$app->urlManager->createUrl('category/create'),
                'categoriesDataProvider' => new CategoryControllerIndexDataProvider()
            ]
        );
    }


    /**
     * render a view of a Category's data
     */
    public function actionView($id)
    {
        $category = Category::find()->where('id = :_id', [':_id' => $id])->one();

        if($category === NULL) {
            throw new HttpException(404, "Category {$id} Not Found");
        }

        return $this->render(
            'view',
            [
                'indexUrl' => Yii::$app->urlManager->createUrl('category/index'),
                'category' => $category
            ]
        );
    }

    /**
     * create a new Category record
     */
    public function actionCreate()
    {
        $category = new Category();
        $errors   = [];

        if(Yii::$app->request->isPost) {
            $category->load(Yii::$app->request->post());
            if($category->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $category->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'category' => $category,
                'errors'   => $errors
            ]
        );
    }

    /**
     * edit an existing Category record
     */
    public function actionUpdate($id)
    {
        $category = Category::find()->where('id = :_id', [':_id' => $id])->one();
        $errors = [];

        if($category === NULL) {
            throw new HttpException(404, "Category {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $category->load(Yii::$app->request->post());
            if($category->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $category->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'category' => $category,
                'errors'   => $errors
            ]
        );
    }

    /**
     * soft delete a Category record
     */
    public function actionDelete($id)
    {   
        //$errors = [];
        if($category = Category::find()->where('id = :_id', [':_id' => $id])->one()) {
            $category->deleted_at = time();
            if($category->save()) {
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting category: {$id}";
            }
        }
        //  else {
        //     $errors[] = "Unable to locate category: {$id}";
        // }

        // display errors
    }
}
