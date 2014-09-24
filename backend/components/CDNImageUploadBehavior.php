<?php
/***********************************
* I HAVE NO IDEA WHAT I AM DOING!
************************************/

namespace backend\components;


use yii\base\Behavior;
use Aws\S3\S3Client;

class CDNImageUploadBehavior extends Behavior
{


    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'uploadToCDN',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'uploadToCDN',
            ActiveRecord::EVENT_AFTER_DELETE  => 'deleteFromCDN'
        ];
    }

    /**
     * @todo DOCUMENT
     */
    public function uploadToCDN()
    {
        $success = FALSE;
        if(!empty($this->owner->image_path)) {
            $key             = substr($this->owner->image_path, (strrpos($this->owner->image_path, '/') + 1));
            $full_local_path = getcwd() . '/' . $this->owner->image_path;
            if(file_exists($full_local_path)) {
                $client = S3Client::factory(
                    [
                        'key'    => getenv('AWS_ACCESS_KEY_ID'),
                        'secret' => getenv('AWS_SECRET_ACCESS_KEY')
                    ]
                );
                $uploaded = $client->putObject(
                    [
                        'Bucket'     => 'ddoddev',
                        'Key'        => $key,
                        'SourceFile' => $full_local_path,
                        'ACL'        => 'public-read'
                    ]
                );
                if(!empty($uploaded) && isset($uploaded['ObjectURL']) && !empty($uploaded['ObjectURL'])) {
                    $success = TRUE;
                    unlink($full_local_path);
                }
            }
        }
        return $success;
    }

    /*
    // ////////////// IMAGE UPLOAD TO S3 SEQUENCE //////////////////////////////////////////////////////////////
    $image->image = UploadedFile::getInstance($image, 'image');
    if(!empty($image) && $image->validate()) {
        // create local file
        $uploaded     = null;
        $filename     = null;
        $dirname      = 'uploads/' . substr($blogger->className(), (strrpos($blogger->className(), '\\') + 1));
        $full_dirname = getcwd() . '/' . $dirname;
        if(!file_exists($full_dirname) && !is_dir($full_dirname)) {
            mkdir($full_dirname, 0774);         
        } 
        if(is_dir($full_dirname)) {
            $filename = $dirname . '/' . 
                md5($blogger->id) . '-' . $image->image->baseName . '.' . $image->image->extension
            ;
            if($image->image->saveAs($filename)) {
                // upload the file locally
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
                            'Bucket'     => 'ddoddev',
                            'Key'        => $filename,
                            'SourceFile' => $full_filename,
                            'ACL'        => 'public-read'
                        ]
                    );
                    // save the image's path to the Blogger instance, and delete local file
                    if(!empty($uploaded) && isset($uploaded['ObjectURL']) && !empty($uploaded['ObjectURL'])) {
                        $blogger->image_path = $filename;
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
            error_log("\n\n SOMETHING IS FUCKED WITH MAKING A LOCAL DIR: {$full_dirname} \n\n");
        }
    }
    // ////////////////// END IMAGE UPLOAD SEQUENCE ////////////////////////////////////////////////////////

    */

    /**
     * @todo THIS
     */
    public function deleteFromCDN()
    {
        error_log("\n\n DELETE THIS OBJECT'S IMAGE ASSETS FROM CDN! \n\n");
        return;
    }
}
