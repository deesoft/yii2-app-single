<?php
$_SERVER['SCRIPT_FILENAME'] = APP_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = APP_ENTRY_URL;

/**
 * Application configuration for app functional tests
 */
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/app/config/main.php'),
    require(YII_APP_BASE_PATH . '/app/config/main-local.php'),
    require(YII_APP_BASE_PATH . '/app/config/web.php'),
    require(YII_APP_BASE_PATH . '/app/config/web-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/functional.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
