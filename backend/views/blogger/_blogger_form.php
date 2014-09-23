<?php
	use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Blogger;
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
        <?= $form->field($image,   'image')->fileInput(); ?>
        <?= $form->field($blogger, 'short_description')->textarea(); ?>
        <?= $form->field($blogger, 'description')->textarea(); ?>
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
