<?php
/************************************
* CRUD operations for PromotedPosts
*************************************/
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\dataproviders\PromotedPostIndexDP;
use common\models\PromotedPost;

class PromotedpostController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow'   => true,
                        'roles'   => ['author']
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
     * render inventory as list of PromotedPosts
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'createPromotedPostUrl'    => Yii::$app->urlManager->createUrl('promotedpost/create'),
                'promotedPostDataProvider' => new PromotedPostIndexDP()
            ]
        );
    }

    /**
     * create a new PromotedPost record
     */
    public function actionCreate()
    {
        $errors       = [];
        $promotedPost = new PromotedPost();
        $promotedPost->loadDefaultValues();

        if(Yii::$app->request->isPost) {
            $post_request_data = Yii::$app->request->post();
            $promotedPost->load($post_request_data);
            // TODO - MAKE A CALLBACK FOR THIS published_at PROC
            if( isset($post_request_data['promotedpost_published_at_string']) &&
                !empty($post_request_data['promotedpost_published_at_string'])
            ) {
                $promotedPost->published_at = strtotime($post_request_data['promotedpost_published_at_string']);
            }
            if($promotedPost->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $promotedPost->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'promotedPost' => $promotedPost,
                'errors'       => $errors
            ]
        );
    }

    /**
     * edit an existing PromotedPost record
     */
    public function actionUpdate($id)
    {
        $promotedPost = PromotedPost::find()->where('id = :_id', [':_id' => $id])->one();
        $errors       = [];

        if($promotedPost === NULL) {
            throw new HttpException(404, "PromotedPost {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $post_request_data = Yii::$app->request->post();
            $promotedPost->load($post_request_data);
            // TODO - MAKE A CALLBACK FOR THIS published_at PROC
            if( isset($post_request_data['promotedpost_published_at_string']) &&
                !empty($post_request_data['promotedpost_published_at_string'])
            ) {
                $promotedPost->published_at = strtotime($post_request_data['promotedpost_published_at_string']);
            }
            if($promotedPost->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $promotedPost->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'promotedPost' => $promotedPost,
                'errors'       => $errors
            ]
        );
    }

    /**
     * soft delete a PromotedPost record
     */
    public function actionDelete($id)
    {   
        //$errors = [];
        if($promotedPost = PromotedPost::find()->where('id = :_id', [':_id' => $id])->one()) {
            $promotedPost->deleted_at = time();
            if($promotedPost->save()) {
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting PromotedPost: {$id}";
            }
        }
        //  else {
        //     $errors[] = "Unable to locate PromotedPost: {$id}";
        // }

        // display errors
    }
}
