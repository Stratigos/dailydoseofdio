<?php
/***************************
* CRUD operations for Tags
****************************/
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\dataproviders\TagControllerIndexDataProvider;
use common\models\Tag;

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
                        'actions' => ['view', 'create', 'index', 'update', 'delete', 'list'],
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
        return $this->render(
            'index',
            [
                'createTagUrl'     => Yii::$app->urlManager->createUrl('tag/create'),
                'tagsDataProvider' => new TagControllerIndexDataProvider()
            ]
        );
    }


    /**
     * render a view of a Tag's data
     */
    public function actionView($id)
    {
        $tag = Tag::find()->where('id = :_id', [':_id' => $id])->one();

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
        $tag    = Tag::find()->where('id = :_id', [':_id' => $id])->one();
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
        if($tag = Tag::find()->where('id = :_id', [':_id' => $id])->one()) {
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

    /**
     * returns a JSON object containing a list of Tags which match input.
     * @param String $query
     *  Partial or complete value for tags.name for search.
     * @return String
     *  JSON response of list of Tag names which match search.
     */
    public function actionList($query)
    {
        $tagnames = Tag::find()->
            select(['name'])->
            where(['like', 'name', $query])->
            andWhere(['deleted_at' => 0])->
            orderBy(['name' => SORT_ASC])->
            all()
        ;
        // can use ContentNegotiator filter here
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $tagnames;
    }
}
