<?php
defined('MY_USER') or define('MY_USER', 'admin');
defined('MY_PASS') or define('MY_PASS', 'admin');

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== MY_USER || $_SERVER['PHP_AUTH_PW'] !== MY_PASS) {
    header('WWW-Authenticate: Basic realm="initApp"');
    header('HTTP/1.0 401 Unauthorized');
    exit;
}

function execute($env)
{
    $_SERVER['argv'] = ['', "--env={$env}", '--overwrite=n'];
    ob_start();
    ob_implicit_flush();
    require __DIR__ . '/init';
    echo nl2br(ob_get_clean());
    exit();
}
if (isset($_POST['action']) && $_POST['action'] == 'install') {
    execute($_POST['env']);
}
?>
<html>
    <head>
        <title>App Install</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    </head>
    <body>
        <div>
            Env:<input type="text" id="env">
            <button id="btn">Install</button>
        </div>
        <div id="result">
        </div>
        <script >
            $(function () {
                $('#btn').click(function () {
                    $('#result').text('Loading...');
                    $.post(window.location.href, {
                        action: 'install',
                        env: $('#env').val(),
                    }, function (r) {
                        $('#result').html(r);
                    });
                });
            });
        </script>
    </body>
</html>