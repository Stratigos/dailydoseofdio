<div class="container">
    <div class="col-md-8">
        <h1 class="page-header">
            <p>Bloggers</p>
        </h1>
        <?php if(isset($bloggers) && !empty($bloggers)) :?>
            <?php foreach($bloggers as $blogger) : ?>
                <?= $this->context->renderPartial(
                    '@frontend/views/_partials/bloggerDefault.php',
                    ['blogger' => $blogger]
                ); ?>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No Bloggers found.</p>
        <?php endif;?>
    </div>
</div>
