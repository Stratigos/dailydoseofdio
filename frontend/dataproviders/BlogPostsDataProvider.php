<?php
/***************************************************************
* Selects all published Post records belonging to a Blog
****************************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use common\models\Post;

class BlogPostsDataProvider extends ActiveDataProvider
{

	/**
	 * @var $blog_id Int
	 *	blogs.id from which to select posts
	 */
	public $blog_id = 0;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        parent::init();
        
        $this->pagination->defaultPageSize = 10;
        $this->pagination->pageSizeParam   = false;

        $this->query = Post::find()->publishedDesc()->andWhere(['blog_id' => $this->blog_id]);
    }
}
