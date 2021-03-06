<?php
namespace Concrete\Tests\Core\Foundation;

use Illuminate\Filesystem\Filesystem;

class ClassLoaderTestCase extends \PHPUnit_Framework_TestCase
{

    protected function putFileIntoPlace($file, $destinationDirectory)
    {
        $sourceFile =  str_replace(DIRECTORY_SEPARATOR, '/', dirname(__FILE__)) . '/fixtures/' . $file;
        $filesystem = new Filesystem();
        if (!$filesystem->isDirectory($destinationDirectory)) {
            $filesystem->makeDirectory($destinationDirectory, 0755, true);
        }
        $method = 'copy';
        if ($filesystem->isDirectory($sourceFile)) {
            $method = 'copyDirectory';
        }
        $filesystem->$method(
            $sourceFile,
            $destinationDirectory . '/' . basename($file)
        );
    }

    protected function cleanUpFile($root, $destination)
    {
        $filesystem = new Filesystem();
        $destination = explode('/', $destination);
        if ($root == DIR_APPLICATION) {
            $deleteDirectory = $root . '/' . $destination[0] . '/' . $destination[1];
        } else {
            $deleteDirectory = $root . '/' . $destination[0];
        }
        if ($filesystem->isFile($deleteDirectory)) {
            $filesystem->delete($deleteDirectory);
        } else {
            $filesystem->deleteDirectory($deleteDirectory);
        }
    }

}
