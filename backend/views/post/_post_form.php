<?php
    use common\models\Post;
    use common\models\PostTag;
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use dosamigos\datetimepicker\DateTimePicker;
    use dosamigos\selectize\SelectizeTextInput;
    use Zelenin\yii\widgets\Summernote\Summernote;
?>
<div>
    <div id="post-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <p>ERRORS</p>
            <!-- <ul class="form-errors-list has-error help-block">
                <?php /* foreach($errors as $prop_errors) :
                    foreach($prop_errors as $property => $this_prop_errors) :
                        foreach($this_prop_errors as $error) : ?>
                            <li><?= "{$property} : {$error}" ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>                    
                <?php endforeach; */ ?>
            </ul> -->
            <pre><?php echo(print_r($errors)); ?></pre>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'post-form',
        'options' => [
            'class'   => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
        <?= $form->field($post, 'status')->inline()->radioList(
            [
                Post::STATUS_DRAFT     => 'Draft',
                Post::STATUS_PUBLISHED => 'Published'
            ]
        ); ?>
        <?= $form->field($post, 'title'); ?>
        <?= $form->field($post, 'shortname'); ?>
        <div class="form-group field-post-published-at-string">
            <label class="control-label" for="post-published-at-string">Published At</label>
            <?= DateTimePicker::widget([
                'id'             => 'post-published-at-string',
                'name'           => 'post_published_at_string',
                'size'           => 'ms',            
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'value'          => (empty($post->published_at) ? '' : date('Y-m-d H:i:s', $post->published_at)),
                'clientOptions'  => [
                    'format'         => 'yyyy-mm-dd hh:ii:ss',
                    'startView'      => 2,
                    'minView'        => 0,
                    'maxView'        => 4,
                    'autoclose'      => TRUE,
                    'todayBtn'       => TRUE,
                    'todayHighlight' => TRUE
                ]
            ]);?>
        </div>
        <?= $form->field($post, 'category_id')->dropDownList($categories); ?>
        <?= $form->field($post, 'blog_id')->dropDownList($blogs); ?>
        <?= $form->field($post, 'blogger_id')->dropDownList($bloggers); ?>
        <div class="form-group post-image-display">
             <?php if($post->image) : ?>
                <?= Html::img(
                    $post->getImage('250x155'),
                    [
                        'class' => 'form-model-thumbnail',
                        'alt'   => 'POST IMAGE APPEARS HERE',
                        'title' => 'Post image'
                    ]
                ); ?>
            <?php else : ?>
                <p>NO IMAGE UPLOADED</p>
            <?php endif;?>
        </div>
        <?= $form->field($post->image_file, 'image')->fileInput(); ?>
        <?= $form->field($post, 'body')->widget(Summernote::className(), []) ?>
        <?php if($post->type_id) : ?>
            <?= $this->render(
                '_post_' . $post->getMediaTypeName() . '_form',
                [
                    'post_media' => $post_media,
                    'form'       => $form
                ]
            ); ?>
        <?php endif;?>
        <div class="form-group field-post-tags-selected">
            <label class="control-label" for="post-tags-selected">Post Tags</label>
            <?= SelectizeTextInput::widget([
                'name'          => PostTag::getInputFieldName(),
                'value'         => $post_tags,
                'loadUrl'       => ['tag/list'],
                'options'       => [
                    'class' => 'form-control',
                    'id'    => 'post-tags-selected'
                ],
                'clientOptions' => [
                    'delimiter'     => ',',
                    'plugins'       => ['remove_button'],
                    'valueField'    => 'name',
                    'labelField'    => 'name',
                    'searchField'   => ['name'],
                    'loadThrottle'  => 500,
                    'addPrecedence' => TRUE,
                    'hideSelected'  => TRUE,
                    'create'        => FALSE
                ],
            ]) ?>
        </div>

        <div id='post-form-tag-list-cont' class="form-group">
            <?php /*
                THIS NEEDS TO BECOME A SELECT DROPDOWN
                THAT IS HIDDEN ON LOAD, DISPLAYS WITH ONCLICK OF HELPER
                LINK OR BUTTON OR IMAGE, AND DISPLAYS ALL AVAILABLE TAGS.
                WHEN A TAG IS SELECTED, ITS ADDED TO THE LIST ABOVE
            */ ?>
            <p>TAGS:</p>
            <?php if(!empty($tags)): ?>
                <p>There are <?= count($tags); ?> Tags in this system (UNDER CONSTRUCTION).</p>
            <?php else: ?>
                <p>No Tags found.</p>
            <?php endif;?>
        </div>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>