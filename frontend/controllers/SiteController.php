<?php
/******************************
* Default Controller
*******************************/
namespace frontend\controllers;

use Yii;
use frontend\dataproviders\HomepagePostsDataProvider;
use frontend\models\ContactForm;

class SiteController extends FrontendController
{

    /**
     * Homepage action
     * @return VOID
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'postsDP'    => new HomepagePostsDataProvider(),
                'archiveUrl' => Yii::$app->urlManager->createUrl(
                    array(
                        'archive/index',
                        'page' => 2
                    )
                )
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
