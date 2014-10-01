<?php
/*****************************************
* Basic class for uploading images/files
******************************************/
namespace common\models;

use yii\base\Model;

class UploadForm extends Model
{
    /**
     * @var Uploaded image|Null image-specific attribute
     */
    public $image;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['image'],
                'image',
                'extensions' => ['png', 'jpg', 'gif'],
                'mimeTypes'  => ['image/png', 'image/jpeg', 'image/gif'],
                'maxSize'    => 2000000,
                'minWidth'   => 100,
                'minHeight'  => 100
            ]
        ];
    }
}