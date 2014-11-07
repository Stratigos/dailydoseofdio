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
use common\models\Tag;

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
     * @var Array
     *  List of all available Tags
     */
    protected $tags;

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
        $this->tags       = Tag::find()->where(['deleted_at' => 0])->orderBy(['name' => SORT_ASC])->all();
    }

    /**
     * @todo DOCUMENT
     */
    public function getFormattedContent()
    {
        $content = [
            'categories' => ['None'],
            'blogs'      => ['None'],
            'bloggers'   => ['None'],
            'tags'       => self::getTags()
        ];
        // create array of relational datatypes' id => name/title for <select>

        if($_categories = self::getCategories()) {
            $content['categories'] += ArrayHelper::map($_categories, 'id', 'name');
            //array_unshift($content['categories'], 'None')
        }
        if($_blogs = self::getBlogs()) {
            $content['blogs'] += ArrayHelper::map($_blogs, 'id', 'title');
        }
        if($_bloggers = self::getBloggers()) {
            $content['bloggers'] += ArrayHelper::map($_bloggers, 'id', 'name');
        }

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

    /**
     *
     */
    public function getTags()
    {
        return $this->tags;
    }
}
