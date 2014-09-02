<?php
    $this->title                   = "Update Post {$post->id}";
    $this->params['breadcrumbs'][] = array(
        'label' => 'Posts Index',
        'url'   => Yii::$app->urlManager->createUrl('post/index')
    );
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div>
        <h3>Update Post (ID: <?= $post->id ?>)</h3>
    </div>
    <div class="body-content">
        <?php echo(
            $this->render(
                '_post_form',
                [
                    'categories' => $categories,
                    'blogs'      => $blogs,
                    'bloggers'   => $bloggers,
                    'tags'       => $tags,
                    'post'       => $post,
                    'post_tags'  => $post_tags,
                    'post_media' => $post_media,
                    'errors'     => $errors
                ]
            )
        ); ?>
    </div>
</div>