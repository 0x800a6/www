<?php
require_once 'config.php';

$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

$key = str_replace('/git', '', $path);
$key = trim($key, '/');

if (empty($key)) {
    http_response_code(302);
    header('Location: ' . $github_link);
    exit;
}

if (isset($git_paths[$key])) {
    http_response_code(302);
    header('Location: ' . $git_paths[$key]);
    exit;
} else {
    http_response_code(302);
    header('Location: ' . $github_link . '/' . $key);
    exit;
}
?>
