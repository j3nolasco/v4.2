<?php

$root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
$url = filter_input(INPUT_SERVER, 'REQUEST_URI') ?? '';
$directories = explode('/', $url);
if (count($directories) > 1) {
    $appPath = implode('/', $directories) . '/';
} else {
    $appPath = '/';
}
$cssPath = "{$appPath}public/css/style.css";
$jsPath = "{$appPath}public/js/app.js";
?>