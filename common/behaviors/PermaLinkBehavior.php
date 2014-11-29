<?php
/********************************************
* Produce URLs and link tags for a Post
*********************************************/

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\Html;

class PermaLinkBehavior extends Behavior
{
	/**
	 * @var $pathname String
	 * Partial path / Controller Action name to Model permalink,
	 * e.g., "category" in "category/rainbow"
	 * @see self::getUrl()
	 */
	public $pathname;

	/**
	 * @var $shortnameAttr String
	 *	Model attribute to use for url shortname
	 */
	public $shortnameAttr;

	/**
	 * @var $linknameAttr String
	 *	Model attribute to use for hyperlink text
	 */
	public $linknameAttr;

	/**
	 * Creates a URL for a Category permalink
	 * @return String 
	 */
	public function getUrl()
	{
		return Yii::$app->urlManager->createUrl("{$this->pathname}/{$this->owner->{$this->shortnameAttr}}");
	}

	/**
	 * Creates an <a> tag for a Category permalink
	 * @return String
	 */
	public function getLinkTag()
	{
		return Html::a($this->owner->{$this->linknameAttr}, $this->owner->url);
	}
}
