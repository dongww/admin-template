<?php
/**
 * User: dongww
 * Date: 2016/3/24
 * Time: 17:47
 */

namespace AdminTemplate\Command;

use AdminTemplate\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Webmozart\PathUtil\Path;

class StaticFilesGenerator extends Command
{
    protected $fs;

    protected function configure()
    {
        $this
            ->setName('files:generator')
            ->setDescription('Generate static files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Creating...');

        $this->clearDistDir($output);
        $this->generateFiles($output);
        $this->generateTpls($output);

        $output->writeln('It\'s all right!');
    }

    protected function getFs()
    {
        if (!$this->fs) {
            $this->fs = new Filesystem();
        }

        return $this->fs;
    }

    protected function clearDistDir(OutputInterface $output)
    {
        $fs = $this->getFs();

        $finder = new Finder();
        $finder
            ->directories()
            ->depth('== 0')
            ->in(Application::$targetPath);

        foreach ($finder as $dir) {
            $fs->remove($dir->getRealpath());
        }

        $finder = new Finder();
        $finder
            ->files()
            ->in(Application::$targetPath)
            ->exclude('.git')
            ->notName('run.bat')
            ->notName('.gitkeep');

        foreach ($finder as $file) {
            $fs->remove($file->getRealpath());
        }

        $output->writeln(' - Dist directory already clean.');
    }

    protected function generateFiles(OutputInterface $output)
    {
        $finder = new Finder();
        $finder
            ->files()
            ->in(Application::$builderPath)
            ->exclude([
                'src',
                'templates',
                'vendor',
            ])
            ->notName('bootstrap.php')
            ->notName('composer.json')
            ->notName('composer.lock')
            ->notName('config.yml')
            ->notName('console')
            ->notName('index.php')
            ->notName('run.bat');

        $fs = $this->getFs();
        foreach ($finder as $file) {
            $filePath     = $file->getRealpath();
            $relativePath = $file->getRelativePathname();

            $fs->copy($filePath, Application::$targetPath . '/' . $relativePath, true);
        }

        $output->writeln(' - Files has been copied. ');
    }

    public function generateTpls(OutputInterface $output)
    {
        $finder = new Finder();
        $finder
            ->files()
            ->in(Application::$templatePath)
            ->exclude([
                'share',
            ]);

        $fs = $this->getFs();
        foreach ($finder as $file) {
            $relativePath = $file->getRelativePathname();

            if (substr($relativePath, '-5') == '.twig') {
                $path = Path::makeRelative('/', '/' . $file->getRelativePath());

                $html = Application::$twig->render($relativePath, [
                    'base_path' => $path ? $path : '.',
                ]);
                $fs->dumpFile(
                    Application::$targetPath . '/' . Path::changeExtension($relativePath, 'html'),
                    $html
                );
            }
        }

        $output->writeln(' - Template files have been converted completed.');
    }
}