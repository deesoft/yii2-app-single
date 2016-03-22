<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use dee\console\MigrateController as Migrate;

defined('STDOUT') or define('STDOUT', fopen('php://output', 'w'));

/**
 * MigrateController.
 */
class MigrateController extends Controller
{
    public $defaultAction = 'run';
    public $db = 'db';

    public function actionRun($id)
    {
        $cmd = $this->getMigrate();
        $params = ['id' => $id];
        if ($migration = Yii::$app->getRequest()->post('migrations')) {
            $migration = implode(',', $migration);
            ob_start();
            ob_implicit_flush(false);
            $cmd->runAction($id, [$migration]);
            $params['result'] = nl2br(ob_get_clean());
        }
        $params['migrations'] = $cmd->getVersions($id === 'up' ? 'new' : 'history');
        return $this->render('run', $params);
    }

    /**
     * @return Migrate
     */
    protected function getMigrate()
    {
        return new Migrate('cmd', Yii::$app, [
            'interactive' => false,
            'db' => $this->db,
        ]);
    }
}
