<?php
/*********************************
* Scopes for class Post
**********************************/
namespace common\models;

use yii\db\ActiveQuery;

class PostQuery extends ActiveQuery
{
    /**
     * Base criteria for a Post to appear in user facing content.
     * @return self
     */
    public function published()
    {
        $this->andWhere(
            'published_at <= ' . time() .
            ' AND status = '. Post::STATUS_PUBLISHED .
            ' AND deleted_at = 0'
        );
        return $this;
    }
}
