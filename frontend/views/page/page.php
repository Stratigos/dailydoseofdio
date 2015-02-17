<div class="container">
    <div class="col-md-8">
        <div class="container">
            <h1 class="page-header"><?= $page->title; ?></h1>
        </div>
        <div class="container">
            <?php if($page && $page->body): ?>
                <p><?= $page->body ?></p>
            <?php endif;?>
        </div>
    </div>
</div>
