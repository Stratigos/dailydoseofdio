<?php
/*************************************************************************
* Behavior component for attributing and saving PostTags to a Post
*  - can be abstracted back to {$model}TagAttributionBehavior if needed
**************************************************************************/

namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ImageUploadBehavior extends Behavior
{

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            // ActiveRecord::EVENT_INIT            => 'someInitFunction',
            // ActiveRecord::EVENT_BEFORE_VALIDATE => 'someSetupAndSaveFunction'
        ];
    }

    // essentially, perform the following operation (and make that string literal a property of PostTag:
    // Save any Tags added to Post
    /*if( isset($post_request_data['post_tag_names_selected']) &&
        !empty($post_request_data['post_tag_names_selected'])
    ) {
        $post_tags_array = explode(',', $post_request_data['post_tag_names_selected']);
        if(!empty($post_tags_array)) {
            foreach($post_tags_array as $tag_name) {
                $tag = Tag::find()->where('name = :_name', [':_name' => $tag_name])->one();
                if($tag) {
                    $post_tag          = new PostTag();
                    $post_tag->post_id = $post->id;
                    $post_tag->tag_id  = $tag->id;
                    if(!$post_tag->save()) {
                        $errors[PostTag::className()][$tag->id] = $post_tag->getErrors();
                    }
                }
            }
        }
    } */
}