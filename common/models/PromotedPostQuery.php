<?php
/*********************************
* Scopes for class PromotedPost
**********************************/
namespace common\models;

use yii\db\ActiveQuery;

class PromotedPostQuery extends ActiveQuery
{
    /**
     * Base criteria for a PromotedPost to appear in user facing content.
     * @return self
     */
    public function published()
    {
        $this->andWhere(
            'published_at < ' . time() .
            ' AND status = '. PromotedPost::STATUS_PUBLISHED .
            ' AND deleted_at = 0'
        );

        return $this;
    }

    /**
     * Adds descending sort by publish date to published() criteria
     * @return self
     */
    public function publishedDesc()
    {
        $this->published()->addOrderBy(['published_at' => SORT_DESC]);
        return $this;
    }
}
