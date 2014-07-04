<div class="site-index">
    <div>
        <h3>Tag (<?php if(!$tag->isNewRecord): ?><?=$tag->id?><?php else: ?>New<?php endif; ?>)</h3>
    </div>
    <div class="body-content">
        <?php echo($this->render('_tag_form', ['tag' => $tag])); ?>
    </div>
</div>