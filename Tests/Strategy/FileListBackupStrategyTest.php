<?php

namespace Devhelp\Component\Tests\Backup\Strategy;

use Devhelp\Component\Backup\Strategy\FileListBackupStrategy;
use Devhelp\Component\Backup\Type\File;
use League\Flysystem\FilesystemInterface;

/**
 * Class FileListBackupStrategyTest
 *
 * @author <michal@devhelp.pl>
 */
class FileListBackupStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileListBackupStrategy
     */
    private $fileListBackupStrategy;

    /**
     * setUp test
     */
    public function setUp()
    {
        $this->fileListBackupStrategy = new FileListBackupStrategy();
    }

    /**
     * @dataProvider
     */
    public function getFilesProvider()
    {
        return array(
            array(
                array(
                    new File('/web/test1.jpg'),
                    new File('/web/test2.jpg'),
                    new File('/web/test3.jpg'),
                    new File('/web/test4.jpg'),
                    new File('/web/test5.jpg')
                )
            )
        );
    }

    /**
     * @test
     */
    public function setRemoteAdapter()
    {
        $this->assertAttributeEquals(null, 'remoteFilesystem', $this->fileListBackupStrategy);
        $this->fileListBackupStrategy->setRemoteAdapter($this->getRemoteFilesystemMock());
        $this->assertAttributeEquals($this->getRemoteFilesystemMock(), 'remoteFilesystem', $this->fileListBackupStrategy);
    }

    /**
     * @dataProvider getFilesProvider
     * @test
     * @param File[] $files
     */
    public function getFileList(array $files)
    {
        $this->fileListBackupStrategy->setRemoteAdapter($this->getRemoteFilesystemMock());
        $result = $this->fileListBackupStrategy->getFileList();

        foreach ($result as $k => $file) {
            $this->assertEquals($file, $files[$k]);
        }
    }

    /**
     * @return FilesystemInterface
     */
    private function getRemoteFilesystemMock()
    {
        $mock = $this->getMockBuilder('League\Flysystem\FilesystemInterface')
            ->disableOriginalConstructor()
            ->getMock();


        $mock->expects($this->any())
            ->method('listFiles')
            ->will($this->returnValue($this->getArrayFileList()));

        return $mock;
    }

    /**
     * @return array
     */
    private function getArrayFileList()
    {
        return array(
            array('path' => '/web/test1.jpg'),
            array('path' => '/web/test2.jpg'),
            array('path' => '/web/test3.jpg'),
            array('path' => '/web/test4.jpg'),
            array('path' => '/web/test5.jpg')
        );
    }

}