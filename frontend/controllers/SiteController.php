<?php
/******************************
* Default Controller
*******************************/
namespace frontend\controllers;

use Yii;
use common\models\Post;
use frontend\dataproviders\HomepagePostsDataProvider;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * DOING THINGS WITH COMPUTERS
     * @todo document this, h'aint?
     * @return VOID
     */
    public function actionIndex()
    {
        $postsDP = new HomepagePostsDataProvider();

        return $this->render(
            'index',
            [
                'posts'       => $postsDP->getModels(),
                'pagination'  => $postsDP->pagination
            ]
        );
    }

    /**
     * @todo Do I want this? Might delete soon...
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
