<div class="site-index">
    <div>
        <h3>Update Dio-Site (<?= $dioSite->id ?>)</h3>
    </div>
    <div class="body-content">
        <?php echo($this->render('_diosite_form', ['dioSite' => $dioSite])); ?>
    </div>
</div>