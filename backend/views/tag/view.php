<div class="tag-view">
    <div>
        <h3>View a Tag (<?= $tag->id ?>)</h3>
    </div>
    <div class="body-content">
        <ul>
        	<li>ID: <?= $tag->id ?></li>
        	<li>Name: <b><?= $tag->name ?></b></li>
        	<li>Created at: <?= date('Y-m-d H:i:s', $tag->created_at); ?></li>
        	<li>Updated at: <?= date('Y-m-d H:i:s', $tag->updated_at); ?></li>
        	<li>Deleted at: <?= ($tag->deleted_at ? date('Y-m-d H:i:s', $tag->deleted_at) : ''); ?></li>
        </ul>
        <p>
        	&#10144;&nbsp;<a href="<?= $indexUrl ?>">Return to Tag Index</a>
        </p>
    </div>
</div>