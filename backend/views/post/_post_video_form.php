<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Video;
?>
<?php if(!empty($post_media->embed)) : ?>
    <div id="video-display" class="form-group">
        <?= $post_media->embed ?>
    </div>
<?php endif; ?>
<?= $form->field($post_media, 'embed'); ?>
<?= $form->field($post_media, 'title'); ?>
