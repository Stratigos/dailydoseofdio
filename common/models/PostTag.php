<?php
/***************************************
 * relational class for Posts and Tags
 ***************************************/
namespace common\models;

use yii\db\ActiveRecord;

class PostTag extends ActiveRecord
{
    /**
     * @var String
     *  name of input field for Tags (within CMS)
     */
    private static $input_field_name = 'post_tag_names_selected';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id'], 'required'],
            [['post_id'], 'integer'],
            [['tag_id'], 'required'],
            [['tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'tag_id'  => 'Tag ID'
        ];
    }

    /**
     * @return String
     */
    public function getInputFieldName()
    {
        return self::$input_field_name;
    } 
}