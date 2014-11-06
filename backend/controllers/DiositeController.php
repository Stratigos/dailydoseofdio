<?php
namespace backend\controllers;

use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\dataproviders\DiositeControllerIndexDataProvider;
use common\models\DioSite;

/**
 * CRUD operations for DioSites
 */
class DiositeController extends Controller
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
     * render inventory as list of DioSites
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'createDioSiteUrl'     => Yii::$app->urlManager->createUrl('diosite/create'),
                'dioSitesDataProvider' => new DiositeControllerIndexDataProvider()
            ]
        );
    }

    /**
     * create a new DioSite record
     */
    public function actionCreate()
    {
        $dioSite = new DioSite();
        $errors  = [];

        if(Yii::$app->request->isPost) {
            $dioSite->load(Yii::$app->request->post());
            if($dioSite->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $dioSite->getErrors();
            }
        }

        return $this->render(
            'create',
            [
                'dioSite' => $dioSite,
                'errors'  => $errors
            ]
        );
    }

    /**
     * edit an existing DioSite record
     */
    public function actionUpdate($id)
    {
        $dioSite = DioSite::find()->where('id = :_id', [':_id' => $id])->one();
        $errors  = [];

        if($dioSite === NULL) {
            throw new HttpException(404, "DioSite {$id} Not Found");
        }

        if(Yii::$app->request->isPost) {
            $dioSite->load(Yii::$app->request->post());
            if($dioSite->save()) {
                return $this->redirect(['index']);
            } else {
                $errors = $dioSite->getErrors();
            }
        }

        return $this->render(
            'update',
            [
                'dioSite' => $dioSite,
                'errors'  => $errors
            ]
        );
    }

    /**
     * soft delete a DioSite record
     */
    public function actionDelete($id)
    {   
        //$errors = [];
        if($dioSite = DioSite::find()->where('id = :_id', [':_id' => $id])->one()) {
            $dioSite->deleted_at = time();
            if($dioSite->save()) {
                return $this->redirect(['index']);
            } else {
                $errors[] = "Error deleting DioSite: {$id}";
            }
        }
        //  else {
        //     $errors[] = "Unable to locate DioSite: {$id}";
        // }

        // display errors
    }
}
