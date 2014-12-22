<?php
/****************************
* CRUD operations for Blogs
*****************************/
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\dataproviders\BlogControllerIndexDataProvider;
use common\models\Blog;

class BlogController extends Controller
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
                        'actions' => ['view', 'create', 'index', 'update', 'delete'],
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
     * render inventory as list of Blogs
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'createBlogUrl'    => Yii::$app->urlManager->createUrl('blog/create'),
                'blogDataProvider' => new BlogControllerIndexDataProvider()
            ]
        );
    }

    /**
     * render a view of a Blog's data
     * @param Int $id
     *  valid blogs.id value
     */
    public function actionView($id)
    {
        $blog = Blog::find()->where('id = :_id', [':_id' => $id])->one();

        if($blog === NULL) {
            throw new HttpException(404, "Blog {$id} Not Found");
        }

        return $this->render(
            'view',
            [
                'indexUrl' => Yii::$app->urlManager->createUrl('blog/index'),
                'blog'     => $blog
            ]
        );
    }

    /**
     * create a new Blog record
     */
    public function actionCreate()
    {
        $errors  = [];
        $blog    = new Blog();
        $blog->loadDefaultValues();

        if(Yii::$app->request->isPost) {
            $blog->load(Yii::$app->request->post());
            if($blog->save()) {
                Yii::$app->session->setFlash('success', "Blog: {$blog->title} created!");
                return $this->redirect(['index']);
            } else {
                $errors = $blog->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'blog'   => $blog,
                'errors' => $errors
            ]
        );
    }

    /**
     * edit an existing Blog record
     */
    public function actionUpdate($id)
    {
        $blog = Blog::find()->where('id = :_id', [':_id' => $id])->one();
        $errors = [];

        if($blog === NULL) {
            throw new HttpException(404, "Blog {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $blog->load(Yii::$app->request->post());
            if($blog->save()) {
                Yii::$app->session->setFlash('success', "Blog: {$blog->title} updated!");
                return $this->redirect(['index']);
            } else {
                $errors = $blog->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'blog'   => $blog,
                'errors' => $errors
            ]
        );
    }

    /**
     * soft delete a Blog record
     */
    public function actionDelete($id)
    {   
        //$errors = [];
        if($blog = Blog::find()->where('id = :_id', [':_id' => $id])->one()) {
            $blog->deleted_at = time();
            if($blog->save()) {
                Yii::$app->session->setFlash('success', "Blog {$blog->title} deleted!");
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting blog: {$id}";
            }
        }
        //  else {
        //     $errors[] = "Unable to locate blog: {$id}";
        // }

        // display errors
    }
}
