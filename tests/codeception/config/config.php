<?php
$_db = is_file(__DIR__ . '/db-local.php') ? require(__DIR__ . '/db-local.php') : [];

/**
 * Application configuration shared by all applications and test types
 */
return [
    'language' => 'en-US',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@tests/codeception/app/fixtures/data',
            'templatePath' => '@tests/codeception/app/templates/fixtures',
            'namespace' => 'tests\codeception\app\fixtures',
        ],
    ],
    'components' => [
        'db' => array_merge([
            'dsn' => 'sqlite:' . dirname(__DIR__) . '/_output/data.sqlite',
            ], $_db),
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
