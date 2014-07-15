<?php
namespace common\models;

use yii\db\ActiveRecord;

class Tag extends ActiveRecord
{
    /**
     * Regular expression used to validate tags.name such that only letters,
     *  numbers, and dashes are allowed. Because fuck underscores in URLs!
     */
    private static $urlFriendlyPattern = '/[^A-Za-z0-9-]+/'; // because fuck underscores in urls!

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
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
            [['name'], 'string', 'length' => [3, 32]],
            [['name'], 'unique'],
            [['name'], 'validateNameURLFriendly']
        ];
    }

    /**
     * validate tags.name such that only url-friendly characters are allowed
     */
    public function validateNameURLFriendly($attribute)
    {
        $value = $this->$attribute;
        if(preg_match(self::$urlFriendlyPattern, $value)) {
            $this->addError($attribute, 'Tag name can only contain letters, numbers, and underscores.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name'
        ];
    }
}