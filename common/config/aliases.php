<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
/**
 * @todo remove const PROJECT_WEB_DIR, and create a backend/config/aliases.php
 *  file which will produce an alias for @uploads to @backend/web/uploads 
 */