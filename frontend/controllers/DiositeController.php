<?php
/*********************************************
* Renders view(s) for listing DioSites
**********************************************/
namespace frontend\controllers;

use common\models\DioSite;
use yii\web\HttpException;

class DiositeController extends FrontendController
{
    /**
     * Load and display a list of all DioSites
     * @return VOID
     */
    public function actionIndex()
    {
        $diosites = DioSite::find()->where(['deleted_at' => 0])->orderBy('title')->all();

        if (!$diosites) {
            throw new HttpException(404, 'No Dio web sites found.');
        }

        return $this->render('index', ['diosites' => $diosites]);
    }
}
