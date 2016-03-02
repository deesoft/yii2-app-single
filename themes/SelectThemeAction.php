<?php

namespace themes;

use Yii;
use yii\web\Cookie;
use yii\base\Action;

/**
 * Description of SelectThemeAction
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SelectThemeAction extends Action
{

    public function run()
    {
        $theme = Yii::$app->request->post('theme');
        if ($theme) {
            if (($id = Yii::$app->user->id) !== null) {
                Yii::$app->cache->set([Theme::THEME_KEY, $id], $theme);
            } else {
                $cookie = new Cookie([
                    'name' => Theme::THEME_KEY,
                    'value' => $theme,
                    'expire' => time() + 365 * 24 * 3600,
                ]);
                Yii::$app->response->cookies->add($cookie);
            }
        }
        Yii::$app->response->format = 'json';
        return true;
    }
}
