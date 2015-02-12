<div class="container">
    <div class="col-md-8">
        <h1 class="page-header">
            <p>Blogs</p>
        </h1>
        <?php if(isset($blogs) && !empty($blogs)) :?>
            <?php foreach($blogs as $blog) : ?>
                <?= $this->context->renderPartial(
                    '@frontend/views/_partials/blogDefault.php',
                    ['blog' => $blog]
                ); ?>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No Blogs found.</p>
        <?php endif;?>
    </div>
</div>
