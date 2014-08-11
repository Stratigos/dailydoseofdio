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
                    'post'       => $post
                ]
            )
        ); ?>
    </div>
</div>