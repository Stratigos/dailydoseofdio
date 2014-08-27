<div class="post-select-media-type">
    <div>
        <h3>Select Media Type</h3>
    </div>
    <div class="body-content">
        <?php if(isset($post_media_types) && !empty($post_media_types)) : ?>
            <ul>
            <?php foreach($post_media_types as $mt_id => $mt_text): ?>
                <li>
                    <h3>
                        <a
                            href="<?= Yii::$app->urlManager->createUrl(['post/create', 'media_type' => $mt_id]); ?>"
                        ><?= ucwords($mt_text); ?></a>
                    </h3>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No media types found! Click <a
                href="<?= Yii::$app->urlManager->createUrl(['post/create', 'media_type' => 0]); ?>"
            >here</a> to create the default type.</p>
        <?php endif; ?>
    </div>
</div>