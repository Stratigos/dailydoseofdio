<?php
/*****************************************************************
* Behavior component for parsing a model's video embed code attribute,
*  to retrieve metadata such as ID or vendor name.
******************************************************************/

namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use backend\models\VideoForm;

class VideoEmbedParseBehavior extends Behavior
{
    /**
     * @var String
     *  Model attribute which is assigned instance of VideoForm
     * @see VideoForm
     */
    public $video_code_field_name = 'video_code';

    /**
     * @var String
     */
    public $video_id_field_name = 'video_id';

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT            => 'initializeVideoCodeAttribute',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'parseVideoCode'
        ];
    }

    /**
     * @todo Document
     */
    public function initializeVideoCodeAttribute()
    {
        $this->owner->{$this->video_code_field_name} = new VideoForm();
    }

    /**
     * @todo DOCUMENT
     * @return Boolean
     *  TRUE on successful validation, parse, and attribution of $owner,
     *  FALSE on failure
     */
    public function parseVideoCode()
    {
        $success = FALSE;

        if(!empty($this->owner->{$this->video_code_field_name})) {
            $video_code = $this->owner->{$this->video_code_field_name};
            $video_code->load(Yii::$app->request->post());
            if($video_code->validate()) {
                $matches = array();
                $match   = preg_match($video_code->videoRegex, $video_code->code, $matches);
                if($match) {
                    $this->owner->{$this->video_id_field_name} = $matches[1];
                    /**
                     * @todo DO A SINGLE MODEL ATTRIBUTE VALIDATION HERE!
                     *  - ensure the resulting ID matches owner's rule for the ID
                     */
                    $success = TRUE;
                } else if($match === 0) {
                    // add to validation errors
                    error_log("\n\n VIDEOEMBEDPARSEBEHAVIOR - NO MATCH FOUND \n\n");
                } else {
                    // add to validation errors
                    error_log("\n\n VIDEOEMBEDPARSEBEHAVIOR - ERROR PARSING VIDEO CODE! \n\n");
                }
            }
        } else {
            $success = TRUE;
        }

        return $success;
    }
}