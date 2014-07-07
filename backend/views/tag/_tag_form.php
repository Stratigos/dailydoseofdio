<?php
	use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>

<div>
    <?php $form = ActiveForm::begin([
        'id'      => 'tag-form',
        'options' => ['class' => 'form-horizontal']
    ]); ?>
        <?= $form->field($tag, 'name'); ?>
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>