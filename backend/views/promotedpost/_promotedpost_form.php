<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use common\models\Post; // TODO: NEEDED?
    use common\models\PromotedPost;
    use Zelenin\yii\widgets\Summernote\Summernote;
    use dosamigos\datetimepicker\DateTimePicker;
?>
<div>
    <div id="promotedpost-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <p>ERRORS</p>
            <pre><?php echo(print_r($errors)); ?></pre>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'promotedpost-form',
        'options' => [
            'class'   => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
        <?= $form->field($promotedPost, 'status')->radioList(
            [
                PromotedPost::STATUS_DRAFT     => 'Draft',
                PromotedPost::STATUS_PUBLISHED => 'Published'
            ]
        ); ?>
        <?=
            $form->field(
                $promotedPost,
                'post_id',
                [
                    'inputOptions' => [
                        'size'      => 11,
                        'maxlength' => 11
                    ]
                ]
            );
        ?>
        <?=
            $form->field(
                $promotedPost,
                'rank',
                [
                    'inputOptions' => [
                        'size'      => 5,
                        'maxlength' => 3
                    ]
                ]
            );
        ?>
        <div class="form-group field-promotedpost-published-at-string">
            <label class="control-label" for="promotedpost-published-at-string">Published At</label>
            <?= DateTimePicker::widget([
                'id'             => 'promotedpost-published-at-string',
                'name'           => 'promotedpost_published_at_string',
                'size'           => 'ms',            
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'value'          => (empty($promotedPost->published_at) ? '' : date('Y-m-d H:i:s', $promotedPost->published_at)),
                'clientOptions'  => [
                    'format'         => 'yyyy-mm-dd hh:ii:ss',
                    'startView'      => 2,
                    'minView'        => 0,
                    'maxView'        => 4,
                    'autoclose'      => TRUE,
                    'todayBtn'       => TRUE,
                    'todayHighlight' => TRUE
                ]
            ]);?>
        </div>
        <div class="form-group promotedpost-image-display">
             <?php if($promotedPost->image) : ?>
                <?= Html::img(
                    $promotedPost->getImage('250x155'),
                    [
                        'class' => 'form-model-thumbnail',
                        'alt'   => 'PROMOTEDPOST IMAGE APPEARS HERE',
                        'title' => 'Promoted Post image'
                    ]
                ); ?>
            <?php else : ?>
                <p>Using Post's image, no custom Promoted Post image uploaded.</p>
            <?php endif;?>
        </div>
        <?= $form->field($promotedPost->image_file, 'image')->fileInput(); ?>
        <?php if($promotedPost->description) : ?>
            <?= $form->field($promotedPost, 'description')->widget(Summernote::className(), []) ?>
        <?php else: /* TODO: JS TO CLICK TO REVEAL FORM FROM ABOVE */ ?>
            <p>Set custom description. *UNDER CONSTRUCTION*</p>
        <?php endif; ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>