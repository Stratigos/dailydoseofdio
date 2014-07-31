<div class="site-index">
    <div>
        <h3>Update Blogger (<?= $blogger->id ?>)</h3>
    </div>
    <div class="body-content">
        <?php echo($this->render('_blogger_form', ['blogger' => $blogger])); ?>
    </div>
</div>