<div class="container">
    <div class="col-md-8">
        <h1 class="page-header">
            <p>Categories</p>
        </h1>
        <?php if(isset($categories) && !empty($categories)) :?>
            <ul>
                <?php foreach($categories as $category) : ?>
                    <li><?= $category->linkTag; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No Categories found.</p>
        <?php endif;?>
    </div>
</div>
