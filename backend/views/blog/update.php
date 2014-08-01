<div class="blog-index">
    <div>
        <h3>Update Blog (<?= $blog->id ?>)</h3>
    </div>
    <div class="body-content">
        <?php echo($this->render('_blog_form', ['blog' => $blog])); ?>
    </div>
</div>
