<?php

namespace themes;

use Yii;
use yii\base\Theme as BaseTheme;

/**
 * Description of Theme
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Theme extends BaseTheme
{
    const THEME_KEY = '_dee_theme';
    public $themes = [];
    public $active;
    public $default;

    public function applyTo($path)
    {
        if (empty($this->themes)) {
            return $path;
        }
        if(($theme = $this->getTheme()) !== false){
            return $theme->applyTo($path);
        }
        return $path;
    }

    private $_theme;
    /**
     *
     * @return BaseTheme|boolean
     */
    public function getTheme()
    {
        if ($this->_theme === false || $this->_theme instanceof BaseTheme) {
            return $this->_theme;
        }
        if ($this->active === null) {
            if (($id = Yii::$app->user->id) !== null) {
                $this->active = Yii::$app->cache->get([self::THEME_KEY, $id]);
            } else {
                $this->active = Yii::$app->request->cookies->getValue(self::THEME_KEY, false);
            }
            if ($this->active === false && $this->default !== null) {
                $this->active = $this->default;
            }
        }
        if (isset($this->themes[$this->active])) {
            $theme = $this->themes[$this->active];
            if (is_string($theme) && strpos($theme, '\\') === false) {
                $theme = [
                    'class' => BaseTheme::className(),
                    'pathMap' => [Yii::$app->getBasePath() => [$theme]]
                ];
            } elseif (is_array($theme) && !isset($theme['class'])) {
                $theme['class'] = BaseTheme::className();
            }
            $this->_theme = $this->themes[$this->active] = Yii::createObject($theme);
        } else {
            $this->_theme = false;
        }
        return $this->_theme;
    }
}
