<?php

require_once __DIR__ . '/functions.php';

session_start();
$json = file_get_contents(__DIR__ . '/../../users/users.json');
$datos = json_decode(preg_replace('/^\xEF\xBB\xBF/', '', $json), true);


$nombre = trim($_REQUEST['name'] ?? '');
$passwd = trim($_REQUEST['passwd'] ?? '');

$ok = false;
foreach ($datos as $u) {
    if (trim($u['user']) === $nombre && trim($u['password']) === $passwd) {
        $ok = true;
        break;
    }
}

if (!$ok) {
    renderError_login(
        401,
        'Authentication failed',
        'Wrong username or password.',
        '../client/autentificador.html',
        'Back to login'
    );
}



header('Location: ./../client/interface_admin.html');
?>