<div class="site-index">
    <div>
        <h1>Tags Management</h1>
        <p class="lead">Create, View, Update, and Delete Tags.</p>
    </div>
    <div class="body-content">
        <div class="row">
            <p><a href="<?= $createTagUrl ?>">Create a new Tag</a></p>
        </div>
            <?php if($tags): ?>
                <?php foreach($tags as $tag): ?>
                    <div class="row">
                        <p><?= $tag->name ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No tags found.</p>
            <?php endif; ?>
            <?php /* <div class="col-lg-4">
                <h2>Content</h2>
                <p>Recent Content...</p>
                <p>
                    <a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a>
                </p>
            </div> */ ?>
        </div>
    </div>
</div>