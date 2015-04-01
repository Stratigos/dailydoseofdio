<?php
    $this->title                   = "Update Promoted Post {$promotedPost->id}";
    $this->params['breadcrumbs'][] = [
        'label' => 'Promoted Posts Index',
        'url'   => Yii::$app->urlManager->createUrl('promotedpost/index')
    ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div>
        <h3>Update Promoted Post (ID: <?= $promotedPost->id ?>)</h3>
        <div><?= $promotedPost->post->title; ?></div>
    </div>
    <br />
    <div class="body-content">
        <?php echo(
            $this->render(
                '_promotedpost_form',
                [
                    'promotedPost' => $promotedPost,
                    'errors'       => $errors
                ]
            )
        ); ?>
    </div>
</div>