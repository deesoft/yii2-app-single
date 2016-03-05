<?php

use yii\web\View;
use themes\adminlte\widgets\SideNav;
use yii\helpers\ArrayHelper;

//use yii\helpers\Html;

/* @var $this View */

$items = ArrayHelper::getValue($this->params, 'sideMenu', []);
?>
<aside class="main-sidebar">

    <section class="sidebar">
        <?php
        echo SideNav::widget([
            'options' => [
                'class' => 'sidebar-menu',
                'items' => $items,
            ]
        ]);
        ?>
    </section>
</aside>
