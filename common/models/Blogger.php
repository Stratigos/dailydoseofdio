<?php
namespace common\models;

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
            [['name'], 'required'],
            [['name'], 'string', 'length' => [3, 64]],
            [['name'], 'unique'],
            [['shortname'], 'required'],
            [['shortname'], 'string', 'length' => [3, 32]],
            [['shortname'], 'unique'],
            [['shortname'], 'validateShortnameURLFriendly'],
            [['image_path'], 'string'],
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
     * @todo ADD S3 URL TO CONFIG
     * @return String
     */
    public function getImage()
    {
        return isset($this->image_path) ? ' https://ddoddev.s3.amazonaws.com/' . $this->image_path : null;
    }
}