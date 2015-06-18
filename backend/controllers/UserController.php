<?php
/************************************
* CRUD operations for Users (admins)
*************************************/
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
//use backend\dataproviders\UserControllerIndexDataProvider;
use common\models\User;

class UserController extends Controller
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
     * render inventory as list of Users
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'createUserUrl'     => Yii::$app->urlManager->createUrl('user/create'),
                'usersDataProvider' => new UserControllerIndexDataProvider()
            ]
        );
    }

    /**
     * create a new User record
     */
    public function actionCreate()
    {
        $user   = new User();
        $errors = [];

        if(Yii::$app->request->isPost) {
            $user->load(Yii::$app->request->post());
            if($user->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $user->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'user'   => $user,
                'errors' => $errors
            ]
        );
    }

    /**
     * edit an existing User record
     */
    public function actionUpdate($id)
    {
        $user   = User::find()->where('id = :_id', [':_id' => $id])->one();
        $errors = [];

        if($user === NULL) {
            throw new HttpException(404, "User {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $user->load(Yii::$app->request->post());
            if($user->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $user->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'user'   => $user,
                'errors' => $errors
            ]
        );
    }

    /**
     * soft delete a User record
     */
    public function actionDelete($id)
    {   
        if($user = User::find()->where('id = :_id', [':_id' => $id])->one()) {
            $user->deleted_at = time();
            if($user->save()) {
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting user: {$id}";
            }
        }
    }
}
