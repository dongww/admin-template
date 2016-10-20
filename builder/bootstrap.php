<?php
/**
 * User: dongww
 * Date: 2016/3/24
 * Time: 18:57
 */
use AdminTemplate\Application;

/** 路径设置 */
Application::$builderPath  = __DIR__;
Application::$templatePath = Application::$builderPath . '/templates';
Application::$targetPath   = realpath(__DIR__ . '/../dist');

/** 配置模板引擎 */
$loader = new Twig_Loader_Filesystem(Application::$templatePath);
$twig   = new Twig_Environment($loader, []);

Application::$twig = $twig;
