<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Quote;
    use Zelenin\yii\widgets\Summernote\Summernote;
?>
<?= $form->field($post_media, 'body')->widget(Summernote::className(), []) ?>
<?= $form->field($post_media, 'source'); ?>
