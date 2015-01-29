<?php
/*******************************************
* Dose Archives
*  lists of Posts (index by date, etc)
********************************************/
namespace frontend\controllers;

use frontend\controllers\FrontendController;
use frontend\dataproviders\PostsDataProvider;
use yii\web\HttpException;

class ArchiveController extends FrontendController
{
	/**
	 * Produce list of Category names and URLs
	 * @return VOID
	 */
	public function actionIndex()
	{
	    $postsDP = new PostsDataProvider();
	    return $this->render(
	        'index',
	        [
	            'posts'      => $postsDP->getModels(),
	            'pagination' => $postsDP->pagination
	        ]
	    );
	}
}