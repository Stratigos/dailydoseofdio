<div class="container">
    <div class="col-md-8 text-center">
        <h1 class="page-header">Categories</h1>
        <?php if(isset($categories) && !empty($categories)) :?>
            <div class="list-group">
                <?php foreach($categories as $category) : ?>
                    <a href="<?= $category->url ?>" class="list-group-item"><strong><?= $category->name ?></strong></a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No Categories found.</p>
        <?php endif;?>
    </div>
    <div class="col-md-4">
        <?= $this->context->renderPartial('@frontend/views/_partials/sidebar.php'); ?>
    </div>
</div>
