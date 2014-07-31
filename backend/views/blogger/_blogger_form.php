<?php
	use yii\helpers\Html;
    use yii\widgets\ActiveForm;
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
        'options' => ['class' => 'form-horizontal']
    ]); ?>
        <?= $form->field($blogger, 'name'); ?>
        <?= $form->field($blogger, 'shortname'); ?>
        <!-- IMAGE GOES HERE -->
        <?= $form->field($blogger, 'short_description')->textarea(); ?>
        <?= $form->field($blogger, 'description')->textarea(); ?>
        <?= $form->field($blogger, 'dio_favorite'); ?>
        <?= $form->field($blogger, 'rank'); ?>
        <?= $form->field($blogger, 'status'); ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>