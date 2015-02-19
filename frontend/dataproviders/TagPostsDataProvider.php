<?php
/***************************************************************
* Selects all published Post records belonging to a Tag
****************************************************************/
namespace frontend\dataproviders;

use yii\data\ActiveDataProvider;
use common\models\Post;
use common\models\Tag;

class TagPostsDataProvider extends ActiveDataProvider
{
    /**
     * @var $tag_id Int
     *  tags.id from which to select posts
     * @see common/models/PostTag
     *  Model / table through wich Tags and Posts are related  
     */
    public $tag_id = 0;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->pagination->defaultPageSize = 10;
        $this->pagination->pageSizeParam   = false;

        $this->query = Post::find()->publishedDesc()->innerJoinWith('tags')->where(
            Tag::tableName() . '.id = :tag_id',
            ['tag_id' => $this->tag_id]
        );
    }
}
