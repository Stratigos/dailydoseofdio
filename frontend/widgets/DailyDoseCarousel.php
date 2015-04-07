<?php
/************************************************************************
* Renders a Bootstrap Carousel with PromotedPosts as content.
* @see http://getbootstrap.com/javascript/#carousel
* @see http://www.yiiframework.com/doc-2.0/yii-bootstrap-carousel.html
* @see common/models/PromotedPost
*************************************************************************/

use common/models/PromotedPost;
use yii/bootstrap/Carousel;
use yii/helpers/Html;

class DailyDoseCarousel extends Carousel {

	/**
	 * Selects default DataProvider if none passed into widget() call.
	 * @inheritdoc
	 */
	public function init()
	{
		// if (!isset($this->dataProvider)) { }
		parent::init();
	}

	/**
	 * Load PromotedPosts from DataProvider, and apply content
	 *	to Carousel properties.
	 * @inheritdoc
	 */
	protected function renderContent()
	{
		// if (isset($this->dataProvider)) {}
		return;
	}
}
