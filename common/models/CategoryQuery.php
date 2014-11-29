<?php
/*********************************
* Scopes for class Category
**********************************/
namespace common\models;

use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    /**
     * Base criteria for a Category to appear in user facing content.
     * @return self
     */
    public function published()
    {
        $this->andWhere(['deleted_at' => 0]);

        return $this;
    }

    /**
     * Adds descending sort by name to published() criteria
     * @return self
     */
    public function publishedDesc()
    {
        $this->published()->addOrderBy(['name' => SORT_DESC]);
        return $this;
    }
}
