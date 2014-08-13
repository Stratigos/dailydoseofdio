<?php
	use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Post;
?>
<div>
    <div id="post-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <p>ERRORS</p>
            <ul class="form-errors-list has-error help-block">
                <?php foreach($errors as $prop_errors) :
                    foreach($prop_errors as $property => $this_prop_errors) :
                        foreach($this_prop_errors as $error) : ?>
                            <li><?= "{$property} : {$error}" ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>                    
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'post-form',
        'options' => ['class' => 'form-horizontal']
    ]); ?>
        <?= $form->field($post, 'status')->radioList(
            array(
                Post::STATUS_DRAFT     => 'Draft',
                Post::STATUS_PUBLISHED => 'Published'
            )
        ); ?>
        <?= $form->field($post, 'title'); ?>
        <?= $form->field($post, 'shortname'); ?>
        <?= $form->field($post, 'body')->textarea(); ?>
        <?= $form->field($post, 'category_id')->dropDownList($categories); ?>
        <?= $form->field($post, 'blog_id')->dropDownList($blogs); ?>
        <?= $form->field($post, 'blogger_id')->dropDownList($bloggers); ?>
        <div id='post-form-tag-list-cont'>
            <p>TAGS:</p>
            <?php if(!empty($tags)): ?>
                <ul id="post-form-tag-list">
                    <?php foreach($tags as $tag): ?>
                        <li>
                            <a
                                href="#"
                                data-tag-shortname="<?= $tag->shortname; ?>"
                                data-tag-id="<?= $tag->id; ?>"
                            ><?= $tag->name; ?></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            <?php else: ?>
                <p>No Tags found.</p>
            <?php endif;?>
        </div>
        <!--
            TODO: include posts.type_id switch here, and include a new partial form
                depending on the Post type selected (img, video, quote, etc...)
              - then include list of Tag instances for now, and crate ctrl routine
                to add PostTags to Post on save
              - then include datepicker to set published_at
        -->
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>