<div class="site-index">
    <div>
        <h3>Create New Blogger</h3>
    </div>
    <div class="body-content">
        <?php echo(
            $this->render(
                '_blogger_form',
                [
                    'blogger' => $blogger,
                    'image'   => $image
                ]
            )
        ); ?>
    </div>
</div>
