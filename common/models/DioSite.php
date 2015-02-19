<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\Html;

class DioSite extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%diosites}}';
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
            [['url'], 'required'],
            [['url'], 'string', 'max' => 2000],
            [['url'], 'url'],
            [['title'], 'string', 'length' => [3, 64]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'url'   => 'URL',
            'title' => 'Title'
        ];
    }

    /**
     * Produce an <a> tag for the Dio site.
     * @return String
     */
    public function getExternalLinkTag()
    {
        return Html::a(
            $this->title,
            $this->url,
            [
                'title'  => "External Link to {$this->title}",
                'target' => '_blank'
            ]
        );
    }
}