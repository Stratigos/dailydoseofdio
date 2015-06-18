<div class="site-index">
    <div>
        <h3>Update User-Administrator (<?= $user->id ?>)</h3>
    </div>
    <div class="body-content">
        <?php echo($this->render('_user_form', ['user' => $user])); ?>
    </div>
</div>