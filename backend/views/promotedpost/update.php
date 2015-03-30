<?php
    $this->title                   = "Update Promoted Post {$post->id}";
    $this->params['breadcrumbs'][] = [
        'label' => 'Promoted Posts Index',
        'url'   => Yii::$app->urlManager->createUrl('promotedpost/index')
    ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div>
        <h3>Update Promoted Post (ID: <?= $promotedpost->id ?>)</h3>
        <div><?= $promotedpost->post->title; ?></div>
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