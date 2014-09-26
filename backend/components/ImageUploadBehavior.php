<?php
/*****************************************************************
* Behavior component for uploading a Model's thumbnail attribute.
******************************************************************/

namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Aws\S3\S3Client;

class ImageUploadBehavior extends Behavior
{
    /**
     * Model attribute which holds image file validation rule,
     *  such as UploadForm instance.
     */
    public $upload_file_field_name = 'image_file';

    /**
     * Model attribute which holds resultant image path.
     */
    public $image_path_field_name = 'image_path';

    /**
     * Model attribute with uniqueness, to assist with uniquely identifying 
     *  image file according to model instance by prefixing filename with a 
     *  hashed value. Attribute must be available at time of validation, thus,
     *  primary key may not be suitable. If configured unset, will result in
     *  unix timestamp as image name prefix.
     */
    public $model_unique_attr;

    /**
     * base directory for file / image uploads
     * @see getUploadBaseDir()
     */
    private $upload_base_dir;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'uploadToCDN',
            ActiveRecord::EVENT_AFTER_DELETE    => 'deleteFromCDN'
        ];
    }

    /**
     * get base directory for uploads
     */
    public function getUploadBaseDir()
    {
        if(!isset($this->upload_base_dir)) {
            $this->upload_base_dir = Yii::$app->params['uploadBaseDir'];
        }
        return $this->upload_base_dir;
    }

    /**
     * get base directory path for image upload
     */
    public function getPartialDirPath()
    {
        return $this->uploadBaseDir . 
            strtolower(
                substr(
                    $this->owner->className(),
                    (strrpos($this->owner->className(), '\\') + 1)
                )
            )
        ;
    }

    /**
     * get full directory path to file, for directory creation, 
     *  and file streaming/upload to CDN
     * @todo USE DEFINED CONSTANT OR SOME SORT OF CONFIG PARAM, 
     *  INSTEAD OF ASSUMING CURRENT WORKING DIRECTORY IS CORRECT
     */
    public function getFullDirPath()
    {
        return getcwd() . '/' . $this->partialDirPath;
    }

    /**
     * Retrieves uploaded instance from $owner, via $owner's instance of
     *  UploadForm, and performs upload. Image is loaded via UploadedFile,
     *  validated, saved locally, sent to the CDN, then deleted locally, and
     *  the resulting filename is saved to the $owner's 
     *  $image_path_field_name. Must be evoked before $owner->save().
     *  @param NULL
     *  @return Boolean
     *   Value representing successful upload, or failure.  
     */
    public function uploadToCDN()
    {
        $success = FALSE;

        if(!empty($this->owner->{$this->upload_file_field_name})) {
            $image_file        = $this->owner->{$this->upload_file_field_name};
            $image_file->image = UploadedFile::getInstance($image_file, 'image');

            if($image_file->validate()) {
                // create local file, and local directory if necessary
                $uploaded = null;
                $filename = null;
                if(!file_exists($this->fullDirPath) && !is_dir($this->fullDirPath)) {
                    mkdir($this->fullDirPath, 0774);         
                } 
                if(is_dir($this->fullDirPath)) {
                    $filename = $this->partialDirPath . '/' .
                        (
                            (isset($this->model_unique_attr) && isset($this->owner->{$this->model_unique_attr})) ?
                                md5($this->owner->{$this->model_unique_attr}) :
                                time()
                        ) .
                        '-' . md5($image_file->image->baseName) .
                        '.' . $image_file->image->extension
                    ;
                    // save the file locally, then upload to CDN
                    if($image_file->image->saveAs($filename)) {
                        /**
                         * @todo USE DEFINED CONST / CONFIG PARAM TO REPRESENT FULL PATH, NOT CWD
                         */
                        $full_filename = getcwd() . '/' . $filename;
                        if(file_exists($full_filename)) {
                            $client = S3Client::factory(
                                [
                                    'key'    => getenv('AWS_ACCESS_KEY_ID'),
                                    'secret' => getenv('AWS_SECRET_ACCESS_KEY')
                                ]
                            );
                            $uploaded = $client->putObject(
                                [
                                    'Bucket'     => Yii::$app->params['s3Bucket'],
                                    'Key'        => $filename,
                                    'SourceFile' => $full_filename,
                                    'ACL'        => 'public-read'
                                ]
                            );
                            // save the image's path to the model instance, and delete local file
                            if(!empty($uploaded) && isset($uploaded['ObjectURL']) && !empty($uploaded['ObjectURL'])) {
                                $this->owner->{$this->image_path_field_name} = $filename;
                                unlink($full_filename);
                            }
                        } else {
                            error_log("\n\n SOMETHING IS FUCKED WITH ACCESSING FULL FILENAME {$full_filename} \n\n");
                        }
                    } else {
                        // add to model's errors
                        error_log("\n\n SOMETHIGN IS FUCKED WITH SAVING AN IMAGE LOCALLY {$filename} \n\n");
                    }
                } else {
                    // add to model's errors
                    error_log("\n\n SOMETHING IS FUCKED WITH MAKING A LOCAL DIR: {$this->fullDirPath} \n\n");
                }

            } else {
                // add to model's errors?
                error_log("\n\n IMAGE DID NOT VALIDATE \n\n");
            }
        }
        return $success;
    }

    /**
     * @todo THIS
     */
    public function deleteFromCDN()
    {
        error_log("\n\n DELETE THIS OBJECT'S IMAGE ASSETS FROM CDN! \n\n");
        return;
    }
}
