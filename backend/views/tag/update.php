<div class="site-index">
    <div>
        <h3>Update Tag (<?= $tag->id ?>)</h3>
    </div>
    <div class="body-content">
        <?php echo($this->render('_tag_form', ['tag' => $tag])); ?>
    </div>
</div>