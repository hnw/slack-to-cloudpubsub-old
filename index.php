<?php
$path = @parse_url($_SERVER['REQUEST_URI'])['path'];
if ($path === '/') {
    $path = 'index.php';
}
$path = sprintf("%s/php/%s", __DIR__, $path);
if (file_exists($path) && is_file($path)) {
    require $path;
} else {
    http_response_code(404);
}
