<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div>
    <div id="user-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <ul class="form-errors-list">
                <?php foreach($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'user-form',
        'options' => ['class' => 'form-horizontal']
    ]); ?>
        <?= $form->field($user, 'username'); ?>
        <?= $form->field($user, 'email'); ?>
        <div class="form-group field-user-pass">
            <?= Html::label('New Password', 'user-pass', ['class' => 'control-label']); ?>
            <?= Html::passwordInput('user_password', null, ['id' => 'user-pass', 'class' => 'form-control']); ?>
        </div>
        <div class="form-group field-user-pass-conf">
            <?= Html::label('Confirm Password', 'user-pass-conf', ['class' => 'control-label']); ?>
            <?= Html::passwordInput('user_password_conf', null, ['id' => 'user-pass-conf', 'class' => 'form-control']); ?>
        </div>
        <?= $form->field($user, 'role')->textInput(['readonly' => true]); ?>
        <?= $form->field($user, 'status')->textInput(['readonly' => true]); ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>