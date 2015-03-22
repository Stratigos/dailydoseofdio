<?php
/*******************************************
* Data model for showcasing specific Posts,
*  typically in a carousel or hero widget.
********************************************/
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class PromotedPost extends ActiveRecord
{
    /**
     * default values for promoted_posts.status
     */
    const STATUS_DRAFT     = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%promoted_posts}}';
    }

    /**
     * Overriding find() to allow for custom scopes
     * @inheritdoc
     * @return PromotedPostQuery
     */
    public static function find()
    {
        return new PromotedPostQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
            ]
        ];

        if(isset(Yii::$app->params['isBackend']) && Yii::$app->params['isBackend']) {
            $behaviors['imageUpload'] = [
                'class'             => 'backend\components\ImageUploadBehavior',
                'model_unique_attr' => 'id'
            ];
        }

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id'], 'required'],
            [['post_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['status'], 'required'],
            [['status'], 'integer', 'min' => 0, 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id'     => 'Post ID',
            'description' => 'Description',
            'status'      => 'Status'
        ];
    }

    /**
     * relation to Post
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id'])->inverseOf('promotedPosts');
    }

    /**
     * get full url to a PromotedPost's image, if one exists, else uses Post's image.
     * @param $size_key String
     *  name of a configured image size (e.g., '250x155')
     * @return String
     */
    public function getImage($size_key = '')
    {
        return (isset($this->image_path)
            ? Yii::$app->params['imageDomain'] . $this->image_path  . $size_key . '.' . $this->image_ext
            : (
                (isset($this->post) && isset($this->post->image))
                    ? $this->post->image
                    : null
            )            
        );
    }

    /**
     * Get a summary of the PromotedPost description, for display in lists.
     *  Uses Post's body if no description set for this PromotedPost.
     * @param $length Int
     *  Length of summarized text, after tags removed. Defaults to 255.
     * @param $allowableTags String
     *  List of HTML tags to allow.
     *  @see http://php.net/manual/en/function.strip-tags.php
     * @return String
     */
    public function getSummary($length = 255, $allowableTags = '<i><b><em><strong>')
    {
        $summary = null;

        if (!empty($this->description)) {
            $summary = $this->summaryHelper($this->description, $length, $allowableTags);
        } else if(isset($this->post) && !empty($this->post->body)) {
            $summary = $this->summaryHelper($this->post->body, $length, $allowableTags);
        }

        return $summary;
    }

    /**
     * String helper for getSummary function.
     * @see PromotedPost::getSummary
     * @todo port this function to a helper class,
     *  and update related code in class Post
     * @param $text String
     *  Body of text to be summarized.
     * @param $length Int
     *  Length of resulting summarized text.
     * @param $allowableTags String
     *  List of HTML tags to allow.
     * @return String
     */
    private function summaryHelper($text, $length, $allowableTags)
    {
        $summary = substr(strip_tags($text, $allowableTags), 0, $length);

        if ($length < strlen($text)) {
            $summary .= ' &hellip;';
        }

        return $summary;
    }
}
