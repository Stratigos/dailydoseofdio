<?php
/*****************************************************
* Ancestor Controller for user facing site requests
******************************************************/
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class FrontendController extends Controller
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
	            'class'           => 'yii\captcha\CaptchaAction',
	            'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : NULL,
	        ]
	    ];
	}
}
