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
     *  Includes relation to Post within it's published() scope.
     * @return self
     */
    public function published()
    {
        $this->andWhere(
            'published_at < ' . time() .
            ' AND status = '. PromotedPost::STATUS_PUBLISHED .
            ' AND deleted_at = 0'
        )->with(
            ['post' => function (PostQuery $query) { $query->published(); }]
        );

        return $this;
    }

    /**
     * Adds sort by rank in descending order clause to published() criteria.
     * @return self
     */
    public function publishedRankDesc()
    {
        $this->published()->addOrderBy(['rank' => SORT_DESC]);

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
