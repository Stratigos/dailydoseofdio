<?php
/********************************************************************
* DataProvider for PostController::actionCreate() and actionUpdate()
*  Selects relational content like Categories, Blogs, and Bloggers
*********************************************************************/
namespace backend\dataproviders;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use common\models\Category;
use common\models\Blog;
use common\models\Blogger;

class PostControllerRelationalContentDataProvider extends ActiveDataProvider
{
    /**
     * @var Array
     *  List of all available Categories
     */
    protected $categories;

    /**
     * @var Array
     *  List of all available Blogs
     */
    protected $blogs;

    /**
     * @var Array
     *  List of all available Bloggers
     */
    protected $bloggers;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->pagination = false;
        $this->categories = Category::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC])->all();
        $this->blogs      = Blog::find()->where(['deleted_at' => 0])->orderBy(['title' => SORT_ASC])->all();
        $this->bloggers   = Blogger::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC])->all();
    }

    /**
     * @todo DOCUMENT
     */
    public static function getFormattedContent()
    {
        $content = [
            'categories' => [],
            'blogs'      => [],
            'bloggers'   => []
        ];
        // create array of relational datatypes' id => name/title for <select>

        if($_categories = self::getCategories()) {
            $content['categories'] = ArrayHelper::map($_categories, 'id', 'name');
            array_unshift($content['categories'], 'None')
        }

        // TODO - REPEAT FOR BLOGS N BLOGGERS, REPLACE REPEATED CODEBLOCK IN POSTCONTROLLER WITH THIS
        
        // $blogs      = ArrayHelper::map($blogs, 'id', 'title');
        // $bloggers   = ArrayHelper::map($bloggers, 'id', 'name');
        // array_unshift($blogs, 'None');
        // array_unshift($bloggers, 'None');

        return $content;
    }

    /**
     * @todo DOCUMENT
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @todo DOCUMENT
     */
    public function getBlogs()
    {
        return $this->blogs;
    }

    /**
     * @todo DOCUMENT
     */
    public function getBloggers()
    {
        return $this->bloggers;
    }
}
