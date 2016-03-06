var sse = new EventSource(_opts.messageUrl);
var $container = $('#message-container');
sse.addEventListener('chat', function (e) {
    var data = JSON.parse(e.data);
    var msgs = data.msgs;
    console.log(data.count + ' message(s) @ ' + data.time);
    jQuery.each(msgs, function () {
        var msg = this;
        var $row;
        if (msg.own == 1) {
            $row = $(_opts.template_me);
        } else {
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
});

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
    if (e.which == 13) {
        chat();
    }
});