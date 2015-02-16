<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Blogger extends ActiveRecord
{

    /**
     * default values for bloggers.status
     */
    const STATUS_HIDDEN    = 0;
    const STATUS_DISPLAYED = 1;

    /**
     * Regular expression used to validate bloggers.shortname such that only lc letters,
     *  numbers, and dashes are allowed.
     */
    private static $shortnameFriendlyPattern = '/[^a-z0-9-]+/';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bloggers}}';
    }

    /**
     * Overriding find() to allow for custom scopes
     * @inheritdoc
     * @return BloggerQuery
     */
    public static function find()
    {
        return new BloggerQuery(get_called_class());
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
                ],
            ],
            'permaLinkBehavior' => [
                'class'         => 'common\behaviors\PermaLinkBehavior',
                'pathname'      => 'blogger',
                'shortnameAttr' => 'shortname',
                'linknameAttr'  => 'name'
            ]
        ];

        if(isset(Yii::$app->params['isBackend']) && Yii::$app->params['isBackend']) {
            $behaviors['imageUpload'] = [
                'class'             => 'backend\components\ImageUploadBehavior',
                'model_unique_attr' => 'shortname'
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
            [['name'], 'required'],
            [['name'], 'string', 'length' => [3, 64]],
            [['name'], 'unique'],
            [['shortname'], 'required'],
            [['shortname'], 'string', 'length' => [3, 32]],
            [['shortname'], 'unique'],
            [['shortname'], 'validateShortnameURLFriendly'],
            [['image_path'], 'string'],
            [['image_ext'], 'string'],
            [['short_description'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2000],
            [['dio_favorite'], 'string', 'max' => 255],
            [['rank'], 'integer', 'min' => 0, 'max' => 999],
            [['status'], 'integer', 'min' => 0, 'max' => 1]
        ];
    }

    /**
     * validate bloggers.shortname such that only url-friendly characters are allowed
     */
    public function validateShortnameURLFriendly($attribute)
    {
        $value = $this->$attribute;
        if(preg_match(self::$shortnameFriendlyPattern, $value)) {
            $this->addError(
                $attribute,
                'Blogger shortname can only contain lower-case letters, numbers, and dashes.'
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'              => 'Name',
            'shortname'         => 'Shortname (URL name)',
            'image_path'        => 'Image Path',
            'image_ext'         => 'Image Extension',
            'short_description' => 'Short Description',
            'description'       => 'Description',
            'dio_favorite'      => 'Dio-Favorite',
            'rank'              => 'Rank',
            'status'            => 'Status'
        ];
    }

    /**
     * relation to Posts
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['blogger_id' => 'id'])->inverseOf('blogger');
    }

    /**
     * get full url to a Blogger's image.
     * @param $size_key String
     *  name of a configured image size (e.g., '75x75')
     * @return String
     */
    public function getImage($size_key = '')
    {
        return isset($this->image_path) ?
            Yii::$app->params['imageDomain'] . $this->image_path  . $size_key . '.' . $this->image_ext :
            NULL
        ;
    }
}