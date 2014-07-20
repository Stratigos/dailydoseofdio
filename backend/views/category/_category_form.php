<?php
	use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div>
    <div id="category-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <ul class="form-errors-list">
                <?php foreach($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'category-form',
        'options' => ['class' => 'form-horizontal']
    ]); ?>
        <?= $form->field($category, 'name'); ?>
        <?= $form->field($category, 'shortname'); ?>
        <?= $form->field($category, 'short_description')->textarea(); ?>
        <?= $form->field($category, 'description')->textarea(); ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>