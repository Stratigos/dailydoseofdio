<div class="category-view">
    <div>
        <h3>View a Category (<?= $category->id ?>)</h3>
    </div>
    <div class="body-content">
        <ul>
        	<li>ID: <?= $category->id ?></li>
        	<li>Name: <b><?= $category->name ?></b></li>
            <li>Shortname: <b><?= $category->shortname ?></b></li>
            <li>Short Description: <?= $category->short_description ?></li>
            <li>Description: <?= $category->description ?></li>
        	<li>Created at: <?= date('Y-m-d H:i:s', $category->created_at); ?></li>
        	<li>Updated at: <?= date('Y-m-d H:i:s', $category->updated_at); ?></li>
        	<li>Deleted at: <?= ($category->deleted_at ? date('Y-m-d H:i:s', $category->deleted_at) : ''); ?></li>
        </ul>
        <p>
        	&#10144;&nbsp;<a href="<?= $indexUrl ?>">Return to Category Index</a>
        </p>
    </div>
</div>