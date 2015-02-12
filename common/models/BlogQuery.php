<?php
/*********************************
* Scopes for class Blog
**********************************/
namespace common\models;

use yii\db\ActiveQuery;

class BlogQuery extends ActiveQuery
{
    /**
     * Base criteria for a Blog to appear in user facing content.
     * @return self
     */
    public function published()
    {
        $this->andWhere(
            [
                'deleted_at' => 0,
                'status'     => 1
            ]
        );

        return $this;
    }

    /**
     * Adds descending sort by name to published() criteria
     * @return self
     */
    public function publishedRank()
    {
        $this->published()->addOrderBy(['rank' => SORT_ASC]);
        return $this;
    }
}
