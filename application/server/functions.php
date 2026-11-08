<?php

function renderError_login(
    int $code,
    string $title,
    string $message,
    string $backUrl = '../client/index.html',
    string $backLabel = 'Back to main Page',
): void {
    http_response_code($code);
    $title     = htmlspecialchars($title);
    $message   = htmlspecialchars($message);
    $backUrl   = htmlspecialchars($backUrl);
    $backLabel = htmlspecialchars($backLabel);
    echo <<<HTML

    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>$title</title>
</head>
<body>
    <h1>$title</h1>
    <p>$message</p>
    <p>
        <a href="$backUrl"><button>$backLabel</button></a>
    </p>
</body>
</html>
HTML;
    exit;
}

function renderError(
    int $code,
    string $title,
    string $message,
    string $backUrl = '../client/index.html',
    string $backUrl_login = '../server/show_one_command.php',
    string $backLabel = 'Back to main Page',
    string $backLabel_ID = 'Back to request another ID'
): void {
    http_response_code($code);
    $title     = htmlspecialchars($title);
    $message   = htmlspecialchars($message);
    $backUrl   = htmlspecialchars($backUrl);
    $backUrl_login   = htmlspecialchars($backUrl_login);
    $backLabel = htmlspecialchars($backLabel);
    echo <<<HTML

    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>$title</title>
</head>
<body>
    <h1>$title</h1>
    <p>$message</p>
    <p>
        <a href="$backUrl"><button>$backLabel</button></a>
        <a href="$backUrl_login"><button>$backLabel_ID</button></a>
    </p>
</body>
</html>
HTML;
    exit;
}


function readOrders(string $file): array
{
    if (!file_exists($file)) {
        renderError(404, 'Orders file not found', 'The orders file cannot be found.', '../client/Interface_admin.html', 'Back to menu');
    }
    $raw = file_get_contents($file);
    if ($raw === false) {
        renderError(404, 'Orders file not readable', 'The orders file could not be read.', '../client/Interface_admin.html', 'Back to menu');
    }
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        renderError(404, 'Orders file corrupted', 'The orders file does not contain valid JSON.', '../client/Interface_admin.html', 'Back to menu');
    }
    return $data;
}