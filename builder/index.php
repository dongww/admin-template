<?php
/**
 * User: dongww
 * Date: 2016/3/24
 * Time: 14:45
 */
use AdminTemplate\Application;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

$filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

/** 启动并运行程序 */
$app = new Application();

$response = $app->handle(
    Request::createFromGlobals()
);

$response->send();