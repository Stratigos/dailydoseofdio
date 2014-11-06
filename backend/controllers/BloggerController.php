<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Controller;
use backend\dataproviders\BloggerControllerIndexDataProvider;
use common\models\Blogger;

/**
 * CRUD operations for Bloggers
 */
class BloggerController extends Controller
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
                        'actions' => ['create', 'index', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
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
     * render inventory as list of Bloggers
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'createBloggerUrl'     => Yii::$app->urlManager->createUrl('blogger/create'),
                'bloggersDataProvider' => new BloggerControllerIndexDataProvider()
            ]
        );
    }

    /**
     * create a new Blogger record
     */
    public function actionCreate()
    {
        $errors  = [];
        $blogger = new Blogger();
        $blogger->loadDefaultValues();

        if(Yii::$app->request->isPost) {
            $blogger->load(Yii::$app->request->post());
            if($blogger->save()) {
                Yii::$app->session->setFlash('success', "Blogger {$blogger->name} created!");
                return $this->redirect(['index']);
            } else {
                $errors = $blogger->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'blogger' => $blogger,
                'errors'  => $errors
            ]
        );
    }

    /**
     * edit an existing Blogger record
     */
    public function actionUpdate($id)
    {
        $errors  = [];
        $blogger = Blogger::find()->where('id = :_id', [':_id' => $id])->one();

        if($blogger === NULL) {
            throw new HttpException(404, "Blogger {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $blogger->load(Yii::$app->request->post());
            if($blogger->save()) {
                Yii::$app->session->setFlash('success', "Blogger {$blogger->name} updated!");
                return $this->redirect(['index']);
            } else {
                $errors = $blogger->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'blogger' => $blogger,
                'errors'  => $errors
            ]
        );
    }

    /**
     * soft delete a Blogger record
     */
    public function actionDelete($id)
    {   
        //$errors = [];
        if($blogger = Blogger::find()->where('id = :_id', [':_id' => $id])->one()) {
            $blogger->deleted_at = time();
            if($blogger->save()) {
                Yii::$app->session->setFlash('success', "Blogger {$blogger->name} deleted!");
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting blogger: {$id}";
            }
        }
        //  else {
        //     $errors[] = "Unable to locate blogger: {$id}";
        // }

        // display errors
    }
}
