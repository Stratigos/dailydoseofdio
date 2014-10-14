<?php
	use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Blogger;
    use Zelenin\yii\widgets\Summernote\Summernote;
?>
<div>
    <div id="blogger-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <ul class="form-errors-list">
                <?php foreach($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'blogger-form',
        'options' => [
            'class'   => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
        <?= $form->field($blogger, 'name'); ?>
        <?= $form->field($blogger, 'shortname'); ?>
        <div class="form-group blogger-image-display">
             <?php if($blogger->image) : ?>
                <img
                    class="form-model-thumbnail"
                    src="<?= $blogger->getImage('200x200') ?>"
                    alt="BLOGGER IMAGE APPEARS HERE, IN THIS SPOT"
                    title="Blogger Image"
                />
            <?php else : ?>
                <p>NO IMAGE UPLOADED</p>
            <?php endif;?>
        </div>
        <?= $form->field($blogger->image_file, 'image')->fileInput(); ?>
        <?= $form->field($blogger, 'short_description')->textarea(); ?>
        <?= $form->field($blogger, 'description')->widget(Summernote::className(), []) ?>
        <?= $form->field($blogger, 'dio_favorite'); ?>
        <?= $form->field($blogger, 'rank')->input('text', array('size' => 20, 'maxlength' => 3)); ?>
        <?= $form->field($blogger, 'status')->radioList(
            array(
                Blogger::STATUS_HIDDEN    => 'Hidden',
                Blogger::STATUS_DISPLAYED => 'Displayed'
            )
        ); ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>
