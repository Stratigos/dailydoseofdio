<div class="post-index">
    <div>
        <h3>Update Post (<?= $post->id ?>)</h3>
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
                    'errors'     => $errors
                ]
            )
        ); ?>
    </div>
</div>