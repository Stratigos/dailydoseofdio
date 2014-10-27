<?php
	use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Blog;
    use Zelenin\yii\widgets\Summernote\Summernote;
?>
<div>
    <div id="blog-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <ul class="form-errors-list">
                <?php foreach($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'blog-form',
        'options' => [
            'class'   => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
        <?= $form->field($blog, 'title'); ?>
        <?= $form->field($blog, 'shortname'); ?>
        <div class="form-group blog-image-display">
             <?php if($blog->image) : ?>
                <img
                    class="form-model-thumbnail"
                    src="<?= $blog->getImage('200x200') ?>"
                    alt="BLOG IMAGE APPEARS HERE, IN THIS SPOT"
                    title="Blog Image"
                />
            <?php else : ?>
                <p>NO IMAGE UPLOADED</p>
            <?php endif;?>
        </div>
        <?= $form->field($blog->image_file, 'image')->fileInput(); ?>
        <?= $form->field($blog, 'short_description')->textarea(); ?>
        <?= $form->field($blog, 'description')->widget(Summernote::className(), []) ?>
        <?= $form->field($blog, 'keywords'); ?>
        <?= $form->field($blog, 'rank')->input('text', array('size' => 20, 'maxlength' => 3)); ?>
        <?= $form->field($blog, 'status')->radioList(
            array(
                Blog::STATUS_HIDDEN    => 'Hidden',
                Blog::STATUS_DISPLAYED => 'Displayed'
            )
        ); ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>
