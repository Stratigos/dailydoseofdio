<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div>
    <div id="diosite-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <ul class="form-errors-list">
                <?php foreach($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'diosite-form',
        'options' => ['class' => 'form-horizontal']
    ]); ?>
        <?= $form->field($dioSite, 'url'); ?>
        <?= $form->field($dioSite, 'title'); ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>