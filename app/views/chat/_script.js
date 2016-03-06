var sse = new EventSource(_opts.messageUrl);
var $container = $('#message-container');
var notifCount = 0;
sse.addEventListener('chat', function (e) {
    var data = JSON.parse(e.data);
    var msgs = data.msgs;
    //console.log(data.count + ' message(s) @ ' + data.time);
    var newmsg = 0;
    jQuery.each(msgs, function () {
        var msg = this;
        var $row;
        if (msg.own == 1) {
            $row = $(_opts.template_me);
        } else {
            newmsg++;
            $row = $(_opts.template_you);
            $row.find('[data-attr="name"]').text(msg.name);
        }
        $row.find('[data-attr="time"]').text(msg.time);
        $row.find('[data-attr="text"]').text(msg.text);
        $container.append($row);
    });
    if (msgs.length) {
        $container.scrollTop($container.prop("scrollHeight"));
    }
    if(newmsg > 0){
        updateNotif(newmsg);
    }
});

function updateNotif(count) {
    if (count > 0) {
        notifCount += count;
        $('#msg-notif').text(notifCount);
        $('#msg-notif').attr('title', notifCount + ' new messages');
    } else if (notifCount > 0) {
        notifCount = 0;
        $('#msg-notif').text('');
        $('#msg-notif').attr('title', '');
    }
}

function chat() {
    var txt = $('#inp-chat').val().trim();
    if (txt != '') {
        $('#inp-chat').val('');
        $.post(_opts.chatUrl, {chat: txt}, function () {

        });
    }
}
$('#btn-chat').click(function () {
    chat();
});

$('#inp-chat').keydown(function (e) {
    updateNotif(0);
    if (e.which == 13) {
        chat();
    }
});
$('#inp-chat').on('click focus',function (){
    updateNotif(0);
});