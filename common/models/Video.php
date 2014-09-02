<?php
/***************************************************************************
* A Video is a link to a web video / media player, or a web video API which
*  loads a media player, and belongs to an instance of Post.
*  - Currently only Youtube share links supported.
****************************************************************************/
namespace common\models;

use yii\db\ActiveRecord;

class Video extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%videos}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id'], 'required'],
            [['post_id'], 'integer'],
            [['embed'], 'required'],
            [['embed'], 'string', 'max' => 2000],
            [['title'], 'string', 'length' => [3, 128]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'embed'   => 'Video Player Embed Code',
            'title'   => 'Video Title'
        ];
    }

    /**
     * relation to Post
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id'])->inverseOf('video');
    }
}
