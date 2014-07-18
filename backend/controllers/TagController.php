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
                        'actions' => ['create', 'index', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
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
            'query'      => Tag::find(),
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
     *
     */
    public function actionDelete()
    {
        // check for AJAX request
        // dont redirect or render anything
    }
}