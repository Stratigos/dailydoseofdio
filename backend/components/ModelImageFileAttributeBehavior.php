<?php
/**********************************************************************
* Behavior component for initializing a Model's attribute used to load
*  instance of UploadForm.
***********************************************************************/

namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\UploadForm;

class ModelImageFileAttributeBehavior extends Behavior
{
    /**
     * Model attribute which will hold instance of UploadForm
     * @see ImageUploadBehavior::$upload_file_field_name
     */
    public $image_file_field_name = 'image_file';

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'initializeImageFileAttribute'
        ];
    }

    /**
     * assigns an instance of UploadForm to Owner's image file attribute
     */
    public function initializeImageFileAttribute()
    {
        $this->owner->{$this->image_file_field_name} = new UploadForm();
    }
}
