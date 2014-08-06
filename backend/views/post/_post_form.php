<?php
	use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Post;
?>
<div>
    <div id="post-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <ul class="form-errors-list">
                <?php foreach($errors as $error) : ?>
                    <li><?= $error ?></li>
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
        <?= $form->field($post, 'category_id'); ?>
        <?= $form->field($post, 'blog_id'); ?>
        <?= $form->field($post, 'blogger_id'); ?>
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