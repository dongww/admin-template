<?php
/**
 * User: dongww
 * Date: 2016/3/24
 * Time: 14:34
 */

namespace AdminTemplate;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Webmozart\PathUtil\Path;

class Application
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Twig_Environment
     */
    public static $twig;
    public static $builderPath;
    public static $templatePath;
    public static $targetPath;

    public function handle(Request $request)
    {
        $this->request = $request;

        $path = $this->getTplFilePath();

        $html = self::$twig->render($path);

        return new Response($html);
    }

    private function getTplFilePath()
    {
        $path = $this->request->getPathInfo();

        if (substr($path, -1) == '/') {
            $path .= 'index.html';
        }

        self::$twig->addGlobal('path', $path);

        $path = Path::changeExtension($path, 'twig');
        $relativePath = Path::makeRelative('/', dirname($path));

        self::$twig->addGlobal(
            'base_path',
            $relativePath ? $relativePath : '.'
        );

        return $path;
    }
}