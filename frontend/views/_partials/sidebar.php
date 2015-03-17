<?php
	use frontend\widgets\AdSidebar;
	use frontend\widgets\DailyDosePortlet;
	use frontend\widgets\DuckDuckGoSearchPortlet;
	use frontend\widgets\SocialSidebar;
?>
<?= DuckDuckGoSearchPortlet::widget() ?>
<?= AdSidebar::widget() ?>
<?= SocialSidebar::widget() ?>
<?= DailyDosePortlet::widget() ?>