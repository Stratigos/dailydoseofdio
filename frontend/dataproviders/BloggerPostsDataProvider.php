<?php
/***************************************************************
* Selects all published Post records belonging to a Blogger
****************************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use common\models\Post;

class BloggerPostsDataProvider extends ActiveDataProvider
{

    /**
     * @var $blogger_id Int
     *  bloggers.id from which to select posts
     */
    public $blogger_id = 0;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->pagination->defaultPageSize = 10;
        $this->pagination->pageSizeParam   = false;

        $this->query = Post::find()->publishedDesc()->andWhere(['blogger_id' => $this->blogger_id]);
    }
}
