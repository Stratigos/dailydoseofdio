<?php
/***************************************************************
* Selects all published Post records belonging to a Category
****************************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Post;

class CategoryPostsDataProvider extends ActiveDataProvider
{

	/**
	 * @var $category_id Int
	 *	categories.id from which to select posts
	 */
	public $category_id = 0;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        parent::init();
        
        $this->pagination->defaultPageSize = 10;
        $this->pagination->pageSizeParam   = false;

        $this->query = Post::find()->publishedDesc()->andWhere(['category_id' => $this->category_id]);
    }
}
