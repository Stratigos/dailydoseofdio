<?php
/*********************************
* Scopes for class Blogger
**********************************/
namespace common\models;

use yii\db\ActiveQuery;

class BloggerQuery extends ActiveQuery
{
    /**
     * Base criteria for a Blogger to appear in user facing content.
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
     * Adds descending sort by rank to published() criteria
     * @return self
     */
    public function publishedRank()
    {
        $this->published()->addOrderBy(['rank' => SORT_ASC]);
        return $this;
    }
}
