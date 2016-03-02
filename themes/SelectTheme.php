<?php

namespace themes;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Description of SelectTheme
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SelectTheme extends Widget
{
    public $options = [];
    public $themes;
    public $action = 'site/change-theme';

    /**
     * 
     * @return string
     */
    public function run()
    {
        $active = null;
        if ($this->themes === null) {
            if (($theme = Yii::$app->getView()->theme) instanceof Theme) {
                $this->themes = array_combine(array_keys($theme->themes), array_keys($theme->themes));
                $active = $theme->active;
            } else {
                $this->themes = [];
            }
        }

        $this->registerScript();
        return Html::dropDownList('', $active, $this->themes, $this->options);
    }

    /**
     * Register script
     */
    protected function registerScript()
    {
        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        $id = $this->options['id'];
        $url = json_encode(Url::to(['/' . ltrim($this->action)]));
        $js = <<<JS
jQuery('#{$id}').change(function(){
    jQuery.post({$url},{theme:jQuery(this).val()},function(){
        location.reload();
    });
});
JS;
        $this->getView()->registerJs($js);
    }
}
