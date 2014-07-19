<div class="site-index">
    <div>
        <h3>Update Category (<?= $category->id ?>)</h3>
    </div>
    <div class="body-content">
        <?php echo($this->render('_category_form', ['category' => $category])); ?>
    </div>
</div>