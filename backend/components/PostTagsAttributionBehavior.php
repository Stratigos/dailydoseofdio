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
     * @var String
     *  Model attribute used for assigning errors. Typically, PostTag is not a
     *  property of its owner (Post), and has no associated attribute.
     */
    public $model_error_attribute = 'id';

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
            foreach($this->owner->postTags as $_post_tag) {
                $_post_tag->delete();
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
                            $this->owner->addError($this->model_error_attribute, $post_tag->getErrors());
                        }
                    } else {
                        $this->owner->addError($this->model_error_attribute, 'Invalid Tags Submission');
                    }
                }
                if(!$this->owner->hasErrors('id')) {
                    $success = TRUE;
                }
            }
        } else {
            $success = TRUE;
        }

        return $success;
    }
}
