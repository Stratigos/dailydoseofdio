<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
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
        $tagsquery  = Tag::find();

        $pagination = new Pagination(
            [
                'defaultPageSize' => 50,
                'totalCount'      => $tagsquery->count(),
            ]
        );

        $tags = $tagsquery->orderBy('id')->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render(
            'index',
            [
                'createTagUrl' => Yii::$app->urlManager->createUrl('tag/create'),
                'tags'         => $tags,
                'pagination'   => $pagination
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
     *
     */
    public function actionUpdate($id)
    {
        $tag = Tag::find($id);

        if($tag === NULL) {
            throw new HttpException(404, "Tag {$id} Not Found");
        }

        // do needful update stuff

        // check for success
        if(0) {
            $this->redirect(Yii::$app->urlManager->createUrl('tag/index'));
        }

        return $this->render('update', ['tag' => $tag]);
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