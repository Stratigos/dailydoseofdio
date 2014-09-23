<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Blogger;
use common\models\UploadForm;

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
        $bloggersDataProvider = new ActiveDataProvider([
            'query'      => Blogger::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC]),
            'pagination' => ['pageSize' => 10]
        ]);

        return $this->render(
            'index',
            [
                'createBloggerUrl'     => Yii::$app->urlManager->createUrl('blogger/create'),
                'bloggersDataProvider' => $bloggersDataProvider
            ]
        );
    }

    /**
     * create a new Blogger record
     */
    public function actionCreate()
    {
        $errors  = [];
        $image   = new UploadForm();
        $blogger = new Blogger();
        $blogger->loadDefaultValues();

        if(Yii::$app->request->isPost) {
            $blogger->load(Yii::$app->request->post());
            $image->image = UploadedFile::getInstance($image, 'image');
            if(!empty($image) && $image->validate()) {
                $image->image->saveAs('uploads/' . $image->image->baseName . '.' . $image->image->extension);
                $blogger->image = 'uploads/' . $image->image->baseName . '.' . $image->image->extension;
            }
            if($blogger->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $blogger->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'blogger' => $blogger,
                'image'   => $image,
                'errors'  => $errors
            ]
        );
    }

    /**
     * edit an existing Blogger record
     */
    public function actionUpdate($id)
    {
        $blogger = Blogger::find()->where('id = :_id', [':_id' => $id])->one();
        $image   = new UploadForm();
        $errors  = [];

        if($blogger === NULL) {
            throw new HttpException(404, "Blogger {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $blogger->load(Yii::$app->request->post());
            $image->image = UploadedFile::getInstance($image, 'image');
            if(!empty($image) && $image->validate()) {
                $image->image->saveAs('uploads/' . $image->image->baseName . '.' . $image->image->extension);
                $blogger->image = 'uploads/' . $image->image->baseName . '.' . $image->image->extension;
            }
            if($blogger->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $blogger->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'blogger' => $blogger,
                'image'   => $image,
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
