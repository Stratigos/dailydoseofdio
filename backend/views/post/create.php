<?php
    $this->title                   = 'Create Post';
    $this->params['breadcrumbs'][] = array(
        'label' => 'Posts Index',
        'url'   => Yii::$app->urlManager->createUrl('post/index')
    );
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div>
        <h3>Create New Post</h3>
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