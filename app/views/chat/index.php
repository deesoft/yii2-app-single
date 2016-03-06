<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this View */
$this->title = 'Simple Chat';
?>
<div class="row">
    <div class="box box-primary direct-chat direct-chat-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Simple Chat</h3>
            <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="" class="badge bg-red" id="msg-notif"></span>
            </div>
        </div>
        <div class="box-body">
            <div class="direct-chat-messages" id="message-container">

            </div>
        </div>
        <div class="box-footer">
            <div class="input-group">
                <input type="text" id="inp-chat" placeholder="Type Message ..." class="form-control">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat" id="btn-chat">Send</button>
                </span>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('template_you') ?>
<div class="direct-chat-msg">
    <div class="direct-chat-info clearfix">
        <span class="direct-chat-name pull-left" data-attr="name"></span>
        <span class="direct-chat-timestamp pull-right" data-attr="time"></span>
    </div>
    <?= Html::img('@web/img/user-you.jpg', ['class' => 'direct-chat-img']) ?>
    <div class="direct-chat-text" data-attr="text"></div>
</div>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('template_me') ?>
<div class="direct-chat-msg right">
    <div class="direct-chat-info clearfix">
        <span class="direct-chat-name pull-right" data-attr="name">Me</span>
        <span class="direct-chat-timestamp pull-left" data-attr="time"></span>
    </div>
    <?= Html::img('@web/img/user-me.jpg', ['class' => 'direct-chat-img']) ?>
    <div class="direct-chat-text" data-attr="text"></div>
</div>
<?php
$this->endBlock();

$opts = json_encode([
    'messageUrl' => Url::to(['message']),
    'chatUrl' => Url::to(['chat']),
    'template_you' => $this->blocks['template_you'],
    'template_me' => $this->blocks['template_me'],
    ]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
