<?php
/********************************************
* Produce URLs and link tags for a Category
*********************************************/

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\Html;

class CategoryLinkBehavior extends Behavior
{
	/**
	 * Creates a URL for a Category permalink
	 * @return String 
	 */
	public function getUrl()
	{
		return Yii::$app->urlManager->createUrl("category/{$this->owner->shortname}");
	}

	/**
	 * Creates an <a> tag for a Category permalink
	 * @return String
	 */
	public function getLinkTag()
	{
		return Html::a($this->owner->name, $this->owner->url);
	}
}
