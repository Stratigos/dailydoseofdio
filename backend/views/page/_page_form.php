<?php
	use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div>
    <div id="page-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <ul class="form-errors-list">
                <?php foreach($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'page-form',
        'options' => ['class' => 'form-horizontal']
    ]); ?>
        <?= $form->field($page, 'title'); ?>
        <?= $form->field($page, 'shortname'); ?>
        <?= $form->field($page, 'body')->textarea(); ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>