<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    	<a href="https://en.wikipedia.org/wiki/Ode" target="_blank">An Ode</a>
    </p>

    <code>print('I Love HTML5!');</code>
</div>
