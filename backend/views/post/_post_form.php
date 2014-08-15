<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\web\JsExpression;
    use common\models\Post;
    use Zelenin\yii\widgets\Summernote\Summernote;
    use dosamigos\datetimepicker\DateTimePicker;
    use dosamigos\selectize\Selectize;
?>
<div>
    <div id="post-form-errors" class="form-errors-cont">
        <?php if(isset($errors) && !empty($errors)) : ?>
            <p>ERRORS</p>
            <ul class="form-errors-list has-error help-block">
                <?php foreach($errors as $prop_errors) :
                    foreach($prop_errors as $property => $this_prop_errors) :
                        foreach($this_prop_errors as $error) : ?>
                            <li><?= "{$property} : {$error}" ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>                    
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin([
        'id'      => 'post-form',
        'options' => ['class' => 'form-horizontal']
    ]); ?>
        <?= $form->field($post, 'status')->radioList(
            array(
                Post::STATUS_DRAFT     => 'Draft',
                Post::STATUS_PUBLISHED => 'Published'
            )
        ); ?>
        <?= $form->field($post, 'title'); ?>
        <?= $form->field($post, 'shortname'); ?>
        <div class="form-group field-post-published-at-string">
            <label class="control-label" for="post-published-at-string">Published At</label>
            <?= DateTimePicker::widget([
                'id'             => 'post-published-at-string',
                'name'           => 'post_published_at_string',
                'size'           => 'ms',            
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'value'          => (empty($post->published_at) ? '' : date('Y-m-d H:i:s', $post->published_at)),
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
        <?= $form->field($post, 'body')->widget(Summernote::className(), []) ?>
        <?= $form->field($post, 'category_id')->dropDownList($categories); ?>
        <?= $form->field($post, 'blog_id')->dropDownList($blogs); ?>
        <?= $form->field($post, 'blogger_id')->dropDownList($bloggers); ?>
        <!--<?php/* = $form->field($post, 'tagNames')->widget(Selectize::className(), [
            'url'           => ['tag/list'],
            'options'       => ['class' => 'form-control'],
            'clientOptions' => [
                'plugins'     => ['remove_button'],
                'valueField'  => 'name',
                'labelField'  => 'name',
                'searchField' => ['name'],
                'create'      => TRUE
            ],
        ])->hint('Use commas to separate tags') */?> -->
        <?= Selectize::widget([
            'name'          => 'test',
            'value'         => 'testtag1, testtag2, testtag3',
            'url'           => ['tag/list'],
            'options'       => ['class' => 'form-control'],
            'clientOptions' => [
                'delimiter' => ',',
                'plugins'   => ['remove_button'],
                'persist'   => FALSE,
                'create'    => new JsExpression("function(input) { return { value: input, text: input }; }")
            ],
        ]) ?>
        <div id='post-form-tag-list-cont'>
            <p>TAGS:</p>
            <?php if(!empty($tags)): ?>
                <ul id="post-form-tag-list">
                    <?php foreach($tags as $tag): ?>
                        <li>
                            <a
                                href="#"
                                data-tag-shortname="<?= $tag->shortname; ?>"
                                data-tag-id="<?= $tag->id; ?>"
                            ><?= $tag->name; ?></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            <?php else: ?>
                <p>No Tags found.</p>
            <?php endif;?>
        </div>
        <!--
            TODO: include posts.type_id switch here, and include a new partial form
                depending on the Post type selected (img, video, quote, etc...)
              - then include list of Tag instances for now, and crate ctrl routine
                to add PostTags to Post on save
        -->
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end(); ?>
</div>