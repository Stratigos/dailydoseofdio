<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Video;
?>
<?php if(!empty($post_media->video_id)) : ?>
    <div id="video-display" class="form-group">
        <?= $post_media->video_id ?>
    </div>
<?php endif; ?>
<?= $form->field($post_media->video_code, 'code'); ?>
<?= $form->field($post_media, 'title'); ?>
