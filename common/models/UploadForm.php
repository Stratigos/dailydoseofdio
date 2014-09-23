<?php
/*****************************************
* Basic class for uploading images/files
******************************************/
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var Uploaded file|Null general file attribute
     */
    public $file;

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
            [['file'], 'file'],
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