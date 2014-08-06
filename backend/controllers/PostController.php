<?php
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Post;

/**
 * CRUD operations for Posts
 */
class PostController extends Controller
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
                        'allow'   => true,
                        'roles'   => ['@']
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
     * render inventory as list of Posts
     */
    public function actionIndex()
    {
        $postsDataProvider = new ActiveDataProvider([
            'query'      => Post::find()->where(['deleted_at' => 0])->orderBy(['published_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 50]
        ]);

        return $this->render(
            'index',
            [
                'createPostUrl'     => Yii::$app->urlManager->createUrl('post/create'),
                'postsDataProvider' => $postsDataProvider
            ]
        );
    }


    /**
     * render a view of a Post's data
     */
    public function actionView($id)
    {
        $post = Post::find()->where('id = :_id', [':_id' => $id])->one();

        if($post === NULL) {
            throw new HttpException(404, "Post {$id} Not Found");
        }

        return $this->render(
            'view',
            [
                'indexUrl' => Yii::$app->urlManager->createUrl('post/index'),
                'post'     => $post
            ]
        );
    }

    /**
     * create a new Post record
     */
    public function actionCreate()
    {
        $errors = [];
        $post   = new Post();
        $post->loadDefaultValues();

        if(Yii::$app->request->isPost) {
            $post->load(Yii::$app->request->post());
            if($post->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $post->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'post'   => $post,
                'errors' => $errors
            ]
        );
    }

    /**
     * edit an existing Post record
     */
    public function actionUpdate($id)
    {
        $post   = Post::find()->where('id = :_id', [':_id' => $id])->one();
        $errors = [];

        if($post === NULL) {
            throw new HttpException(404, "Post {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $post->load(Yii::$app->request->post());
            if($post->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $post->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'post'   => $post,
                'errors' => $errors
            ]
        );
    }

    /**
     * soft delete a Post record
     */
    public function actionDelete($id)
    {   
        //$errors = [];
        if($post = Post::find()->where('id = :_id', [':_id' => $id])->one()) {
            $post->deleted_at = time();
            if($post->save()) {
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting post: {$id}";
            }
        }
        //  else {
        //     $errors[] = "Unable to locate post: {$id}";
        // }

        // display errors
    }
}
