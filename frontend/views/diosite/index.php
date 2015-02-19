<div class="container">
    <div class="col-md-8">
        <h1 class="page-header">
            <p>Dio Sites</p>
        </h1>
        <?php if(isset($diosites) && !empty($diosites)) :?>
            <ul id="diosites-index">
            <?php foreach($diosites as $diosite) : ?>
                <li><?= $diosite->externalLinkTag ?></li>
            <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No Dio sites found.</p>
        <?php endif;?>
    </div>
</div>
