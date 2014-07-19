<?php
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Tag;

/**
 * CRUD operations for Tags
 */
class TagController extends Controller
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
                    // TODO - implement ACLs or Roles, and create lesser role with access to /view/$id

                ]
            ]
            // 'verbs' => [
            //     'class'   => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
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
     * render inventory as list of Tags
     */
    public function actionIndex()
    {
        // TODO - move instance to controller property
        $tagsDataProvider = new ActiveDataProvider([
            'query'      => Tag::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC]),
            'pagination' => ['pageSize' => 50]
        ]);

        return $this->render(
            'index',
            [
                'createTagUrl'     => Yii::$app->urlManager->createUrl('tag/create'),
                'tagsDataProvider' => $tagsDataProvider
            ]
        );
    }


    /**
     * render a view of a Tag's data
     */
    public function actionView($id)
    {
        $tag = Tag::find()->where(['id' => $id])->one();

        if($tag === NULL) {
            throw new HttpException(404, "Tag {$id} Not Found");
        }

        return $this->render(
            'view',
            [
                'indexUrl' => Yii::$app->urlManager->createUrl('tag/index'),
                'tag'      => $tag
            ]
        );
    }

    /**
     * create a new Tag record
     */
    public function actionCreate()
    {
        $tag    = new Tag();
        $errors = [];

        if(Yii::$app->request->isPost) {
            $tag->load(Yii::$app->request->post());
            if($tag->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $tag->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'tag'    => $tag,
                'errors' => $errors
            ]
        );
    }

    /**
     * edit an existing Tag record
     */
    public function actionUpdate($id)
    {
        $tag    = Tag::find()->where(['id' => $id])->one();
        $errors = [];

        if($tag === NULL) {
            throw new HttpException(404, "Tag {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $tag->load(Yii::$app->request->post());
            if($tag->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $tag->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'tag'    => $tag,
                'errors' => $errors
            ]
        );
    }

    /**
     * soft delete a Tag record
     */
    public function actionDelete($id)
    {   
        //$errors = [];
        if($tag = Tag::find()->where(['id' => $id])->one()) {
            $tag->deleted_at = time();
            if($tag->save()) {
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting tag: {$id}";
            }
        }
        //  else {
        //     $errors[] = "Unable to locate tag: {$id}";
        // }

        // display errors
    }
}