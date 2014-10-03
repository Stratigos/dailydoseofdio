<?php
/*************************************************************************
* Behavior component for attributing and saving PostTags to a Post
*  - can be abstracted back to {$model}TagAttributionBehavior if needed
**************************************************************************/

namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\PostTag;
use common\models\Tag;

class PostTagsAttributionBehavior extends Behavior
{

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'saveTags',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveTags'
        ];
    }

    /**
     * @todo DOCUMENT
     * - remove all, re-add all, instead of passing deltas
     */
    public function saveTags()
    {
        $success   = FALSE; 
        $post_data = Yii::$app->request->post();
        // remove current set of PostTags 
        if(!empty($this->owner->postTags)) {
            foreach($this->owner->postTags as $postTag) {
                $postTag->delete();
            }
        }
        //@todo add regex check for letters, numbers, commas, and spaces
        if(isset($post_data[PostTag::getInputFieldName()]) && !empty($post_data[PostTag::getInputFieldName()])) {
            $post_tags_arr = explode(',', $post_data[PostTag::getInputFieldName()]);
            if(!empty($post_tags_arr)) {
                foreach($post_tags_arr as $tag_name) {
                    $tag = Tag::find()->where('name = :_name', [':_name' => $tag_name])->one();
                    if($tag) {
                        $post_tag          = new PostTag();
                        $post_tag->post_id = $this->owner->id;
                        $post_tag->tag_id  = $tag->id;
                        if(!$post_tag->save()) {
                            // add to errors
                            //$errors[PostTag::className()][$tag->id] = $post_tag->getErrors();
                            error_log("\n\n ERROR SAVING POST TAG \n\n");
                        }
                    } else {
                        // add to application logs
                        error_log("\n\n INVALID TAG SUBMITTED {$tag_name} \n\n");
                    }
                }
                // check for errors first...
                $success = TRUE;
            } else {
                // add to application logs
                error_log("\n\n EMPTY TAGS SUBMISSION \n\n");
            }
        }
    }
}
