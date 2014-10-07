<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Video;
?>
<?php if(!empty($post_media->video_id)) : ?>
    <div id="video-display" class="form-group">
        <label class="control-label" for="video-embed">Current Video: </label>
        <br />
        <?= $post_media->youtubeEmbed ?>
    </div>
<?php endif; ?>
<?php
    /*   
        TODO: hide input for $code if $video_id is set, and provide a link
        that onclick will display input.
        TODO: add AJAX functionality, or _POST functionality whatever, to 
        wipe $video_id if needed.
    */
 ?>
<?= $form->field($post_media->video_code, 'code')->hint(
    empty($post_media->video_id) ? '' : 'To update this video, supply a new Youtube URL'
); ?>
<?php /* TODO: implement Youtube API to auto-get Title */?>
<?= $form->field($post_media, 'title'); ?>
