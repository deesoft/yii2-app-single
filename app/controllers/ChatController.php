<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\components\SSE;

/**
 * ChatController.
 */
class ChatController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'chat', 'message'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionChat()
    {
        Yii::$app->getResponse()->format = 'json';
        Yii::$app->getDb()->createCommand()->insert('{{%chat}}', [
            'time' => microtime(true),
            'user_id' => Yii::$app->getUser()->id,
            'text' => Yii::$app->getRequest()->post('chat', '')
        ])->execute();
        return true;
    }

    public function actionMessage()
    {
        $MAX_CONN = 15; // 15 times
        $sse = new SSE();
        try {
            $lastTime = Yii::$app->getRequest()->getHeaders()->get('last-event-id', 0);
            $user_id = Yii::$app->getUser()->id;
            $chats = (new \yii\db\Query())
                ->select(['c.time', 'c.user_id', 'u.username', 'c.text'])
                ->from(['c' => 'chat'])
                ->innerJoin(['u' => 'user'], '[[c.user_id]]=[[u.id]]')
                ->where('[[c.time]]>:ctime')
                ->orderBy(['c.time' => SORT_DESC])
                ->limit(50);

            for ($i = 0; $i <= $MAX_CONN; $i++) {
                $rows = $chats->params([':ctime' => $lastTime])->all();
                $lastTime = microtime(true);
                $msgs = [];
                foreach (array_reverse($rows) as $row) {
                    $msgs[] = [
                        'own' => $row['user_id'] == $user_id,
                        'time' => date('H:i:s', $row['time']),
                        'name' => $row['user_id'] == $user_id ? 'Me' : $row['username'],
                        'text' => $row['text']
                    ];
                }
                $sse->event('chat', ['count' => count($msgs), 'msgs' => $msgs, 'time' => date('H:i:s', $lastTime)]);
                $sse->flush();

                sleep(1);
            }
        } catch (\Exception $exc) {
            $sse->event('error', ['msg' => $exc->getMessage()]);
        }
        $sse->id($lastTime);
        $sse->flush();
        exit();
    }
}
