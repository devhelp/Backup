<?php

namespace Devhelp\Component\Backup\Tests\Strategy;

use Devhelp\Component\Backup\Strategy\FileBackupStrategy;
use Devhelp\Component\Backup\Type\File;

/**
 * Class FileBackupStrategyTest
 * @author <michal@devhelp.pl>
 */
class FileBackupStrategyTest  extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getFileList()
    {
        $fileBackupStrategy = new FileBackupStrategy('/web/test.php');

        $this->assertEquals(array(new File('/web/test.php')), $fileBackupStrategy->getFileList());
    }

    /**
     *
     * @test
     */
    public function testCount()
    {
        $fileBackupStrategy = new FileBackupStrategy('/web/test.php');

        $this->assertEquals(1, $fileBackupStrategy->count());
    }
} 