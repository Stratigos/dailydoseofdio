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
     * Saves the relationship of Tags to a Post. All existing PostTags
     *  are deleted for the current Post, and any Tags added to the
     *  appropriate input field are added to the Post.
     *  @see PostTag::getInputFieldName()
     *  @return Boolean
     *   TRUE on successful save or no action required, FALSE if 
     *   any PostTags fail to save. Errors are attributed to $owner. 
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
