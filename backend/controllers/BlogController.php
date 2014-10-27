<?php
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Blog;

/**
 * CRUD operations for Blogs
 */
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
     * render inventory as list of Blogs
     */
    public function actionIndex()
    {
        $blogDataProvider = new ActiveDataProvider([
            'query'      => Blog::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC]),
            'pagination' => ['pageSize' => 10]
        ]);

        return $this->render(
            'index',
            [
                'createBlogUrl'    => Yii::$app->urlManager->createUrl('blog/create'),
                'blogDataProvider' => $blogDataProvider
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
