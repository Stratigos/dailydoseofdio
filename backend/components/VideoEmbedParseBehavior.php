<?php
/*****************************************************************
* Behavior component for parsing a model's video embed code attribute,
*  to retrieve metadata such as ID or vendor name.
******************************************************************/

namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class VideoEmbedParseBehavior extends Behavior
{
    /**
     * Model attribute which is assigned instance of UploadForm
     * @see UploadForm::rules()
     */
    public $upload_file_field_name = 'image_file';
}