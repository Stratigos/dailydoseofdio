<?php
namespace common\models;

use yii\db\ActiveRecord;

class Post extends ActiveRecord
{
    /**
     * default values for posts.status
     */
    const STATUS_DRAFT     = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * values for posts.type_id, representing Post media types
     */
    const POST_TYPE_TEXT  = 0;
    const POST_TYPE_VIDEO = 1;
    const POST_TYPE_QUOTE = 2;
    const POST_TYPE_IMAGE = 3;

    /**
     * Regular expression used to validate posts.shortname such that only lc letters,
     *  numbers, and dashes are allowed.
     */
    private static $shortnameFriendlyPattern = '/[^a-z0-9-]+/';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    /**
     * returns an array of each posts.type_id value as keys, with
     *  text representations of the types as values.
     */
    public static function getMediaTypes()
    {
        return [
            self::POST_TYPE_TEXT  => 'text',
            self::POST_TYPE_VIDEO => 'video',
            self::POST_TYPE_QUOTE => 'quote',
            self::POST_TYPE_IMAGE => 'image'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'required'],
            [['type_id'], 'integer', 'min' => 0, 'max' => 3],
            [['category_id'], 'required'],
            [['category_id'], 'integer', 'min' => 0],
            [['blog_id'], 'required'],
            [['blog_id'], 'integer', 'min' => 0],
            [['blogger_id'], 'required'],
            [['blogger_id'], 'integer', 'min' => 0],
            [['title'], 'required'],
            [['title'], 'string', 'length' => [3, 128]],
            [['shortname'], 'required'],
            [['shortname'], 'string', 'length' => [3, 128]],
            [['shortname'], 'unique'],
            [['shortname'], 'validateShortnameURLFriendly'],
            [['body'], 'string', 'max' => 65535],
            [['status'], 'required'],
            [['status'], 'integer', 'min' => 0, 'max' => 1],
        ];
    }

    /**
     * validate posts.shortname such that only url-friendly characters are allowed
     */
    public function validateShortnameURLFriendly($attribute)
    {
        $value = $this->$attribute;
        if(preg_match(self::$shortnameFriendlyPattern, $value)) {
            $this->addError(
                $attribute,
                'Post shortname can only contain lower-case letters, numbers, and dashes.'
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id'     => 'Type ID',
            'category_id' => 'Category ID',
            'blog_id'     => 'Blog ID',
            'blogger_id'  => 'Blogger ID',
            'title'       => 'Title',
            'shortname'   => 'Shortname',
            'body'        => 'Body',
            'status'      => 'Status'
        ];
    }

    /**
     * relation to Blog
     */
    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id'])->inverseOf('posts');
    }

    /**
     * relation to Blogger
     */
    public function getBlogger()
    {
        return $this->hasOne(Blogger::className(), ['id' => 'blogger_id'])->inverseOf('posts');
    }

    /**
     * relation to Category
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])->inverseOf('posts');
    }

    /**
     * intermediate relation to Tags (PostTag)
     * @see Post::getTags()
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTag::className(), ['post_id' => 'id']);
    }

    /**
     * relation to Tags
     * @see Post::getPostTags()
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('postTags');
    }

    /**
     * relation to a Quote
     */
    public function getQuote()
    {
        return $this->hasOne(Quote::className(), ['post_id' => 'id'])->inverseOf('post');
    }
}
