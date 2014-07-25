<div class="site-index">
    <div>
        <h3>Update Page (<?= $page->id ?>)</h3>
    </div>
    <div class="body-content">
        <?php echo($this->render('_page_form', ['page' => $page])); ?>
    </div>
</div>