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
     * @dataProvider
     */
    public function getAllFilesProvider()
    {
        return array(
            array(
                array(
                    array('path' => '/web/test1.jpg'),
                    array('path' => '/web/test2.jpg'),
                    array('path' => '/web/test3.jpg'),
                    array('path' => '/web/test4.jpg'),
                    array('path' => '/web/test5.jpg'),
                    array('path' => '/web/test6.png'),
                    array('path' => '/web/test7.gif')
                ),

                array(
                    new File('/web/test1.jpg'),
                    new File('/web/test2.jpg'),
                    new File('/web/test3.jpg'),
                    new File('/web/test4.jpg'),
                    new File('/web/test5.jpg'),
                    new File('/web/test6.png'),
                    new File('/web/test7.gif'),
                )
            )
        );
    }

    /**
     * @dataProvider
     */
    public function getWithIgnoredFileFilesProvider()
    {
        return array(
            array(
                array(
                    array('path' => '/web/test1.jpg'),
                    array('path' => '/web/test2.jpg'),
                    array('path' => '/web/test3.jpg'),
                    array('path' => '/web/test4.jpg'),
                    array('path' => '/web/test5.jpg'),
                    array('path' => '/web/test6.png'),
                    array('path' => '/web/test7.gif')
                ),

                array(
                    new File('/web/test1.jpg'),
                    new File('/web/test2.jpg'),
                    new File('/web/test4.jpg'),
                    new File('/web/test5.jpg'),
                    new File('/web/test6.png'),
                    new File('/web/test7.gif')
                )
            )
        );
    }

    /**
     * @dataProvider
     */
    public function getWithIgnoredExtensionProvider()
    {
        return array(
            array(
                array(
                    array('path' => 'test1.jpg'),
                    array('path' => '/web/test2.jpg'),
                    array('path' => '/web/test/test3.jpg'),
                    array('path' => '/web/test4.jpg'),
                    array('path' => '/web/test/test/test5.jpg'),
                    array('path' => '/web/test6.png'),
                    array('path' => 'test7.gif'),
                    array('path' => 'test/test'),
                ),

                array(
                    new File('/web/test6.png'),
                    new File('test7.gif'),
                    new File('test/test')
                )
            )
        );
    }

    /**
     * @dataProvider
     */
    public function getWithIgnoredDirectoriesProvider()
    {
        return array(
            array(
                array(
                    array('path' => 'test1.jpg'),
                    array('path' => '/web/test2.jpg'),
                    array('path' => '/web/test/test3.jpg'),
                    array('path' => '/web/test4.jpg'),
                    array('path' => '/web/test/test/test5.jpg'),
                    array('path' => '/web/test6.png'),
                    array('path' => 'test7.gif'),
                    array('path' => 'test/test'),
                ),

                array(
                    new File('test1.jpg'),
                    new File('test7.gif'),
                    new File('test/test')
                )
            )
        );
    }

    /**
     * @dataProvider
     */
    public function getWithAllFiltersProvider()
    {
        return array(
            array(
                array(
                    array('path' => 'test1.jpg'),
                    array('path' => '/web/test2.jpg'),
                    array('path' => '/web/test/test3.jpg'),
                    array('path' => '/web/test4.jpg'),
                    array('path' => '/web/test/test/test5.jpg'),
                    array('path' => '/web/test6.png'),
                    array('path' => 'test7.gif'),
                    array('path' => 'test/test.php'),
                ),

                array(
                    new File('test7.gif')
                )
            )
        );
    }

    /**
     * @dataProvider getAllFilesProvider
     * @test
     * @param array $input
     */
    public function setRemoteAdapter(array $input)
    {
        $fileListBackupStrategy = new FileListBackupStrategy();
        $this->assertAttributeEquals(null, 'remoteFilesystem', $fileListBackupStrategy);
        $fileListBackupStrategy->setRemoteAdapter($this->getRemoteFilesystemMock($input));
        $this->assertAttributeEquals($this->getRemoteFilesystemMock($input), 'remoteFilesystem', $fileListBackupStrategy);
    }

    /**
     * @dataProvider getWithIgnoredFileFilesProvider
     * @test
     * @param array $input
     * @param File[] $output
     */
    public function getFileListWithIgnoredFile(array $input, array $output)
    {
        $fileListBackupStrategy = new FileListBackupStrategy();
        $fileListBackupStrategy->setRemoteAdapter($this->getRemoteFilesystemMock($input));

        $fileListBackupStrategy
            ->addIgnoredFiles(new File('/web/test3.jpg'));

        $result = $fileListBackupStrategy->getFileList();

        $this->assertEquals($result, $output);

    }

    /**
     * @dataProvider getWithIgnoredExtensionProvider
     * @test
     * @param array $input
     * @param File[] $output
     */
    public function getFileListWithIgnoredExtensions(array $input, array $output)
    {
        $fileListBackupStrategy = new FileListBackupStrategy();
        $fileListBackupStrategy->setRemoteAdapter($this->getRemoteFilesystemMock($input));

        $fileListBackupStrategy->addIgnoredExtension('jpg');

        $result = $fileListBackupStrategy->getFileList();

        $this->assertEquals($result, $output);
    }


    /**
     * @dataProvider getAllFilesProvider
     * @test
     * @param array $input
     * @param File[] $output
     */
    public function getFileList(array $input, array $output)
    {
        $fileListBackupStrategy = new FileListBackupStrategy();
        $fileListBackupStrategy->setRemoteAdapter($this->getRemoteFilesystemMock($input));

        $result = $fileListBackupStrategy->getFileList();

        $this->assertEquals($result, $output);
    }

    /**
     * @dataProvider getWithIgnoredDirectoriesProvider
     * @test
     * @param array $input
     * @param File[] $output
     */
    public function getFileListWithIgnoredDirectory(array $input, array $output)
    {
        $fileListBackupStrategy = new FileListBackupStrategy();
        $fileListBackupStrategy->setRemoteAdapter($this->getRemoteFilesystemMock($input));

        $fileListBackupStrategy->addIgnoredDirectory('/web');

        $result = $fileListBackupStrategy->getFileList();

        $this->assertEquals($result, $output);
    }

    /**
     * @dataProvider getWithAllFiltersProvider
     * @test
     * @param array $input
     * @param File[] $output
     */
    public function getFilesWithAllFiltersProvider(array $input, array $output)
    {
        $fileListBackupStrategy = new FileListBackupStrategy();
        $fileListBackupStrategy->setRemoteAdapter($this->getRemoteFilesystemMock($input));

        $fileListBackupStrategy->addIgnoredDirectory('/web')
            ->addIgnoredExtension('jpg')
            ->addIgnoredFiles(new File('test/test.php'));
        ;

        $result = $fileListBackupStrategy->getFileList();

        $this->assertEquals($result, $output);
    }

    /**
     * @dataProvider getWithAllFiltersProvider
     * @test
     * @param array $input
     */
    public function testCount(array $input)
    {
        $fileListBackupStrategy = new FileListBackupStrategy();
        $fileListBackupStrategy->setRemoteAdapter($this->getRemoteFilesystemMock($input));

        $fileListBackupStrategy->addIgnoredDirectory('/web')
            ->addIgnoredExtension('jpg')
            ->addIgnoredFiles(new File('test/test.php'));
        ;

        $this->assertEquals(1, $fileListBackupStrategy->count());
    }

    /**
     * @param array $input
     * @return FilesystemInterface
     */
    private function getRemoteFilesystemMock(array $input)
    {
        $mock = $this->getMockBuilder('League\Flysystem\FilesystemInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->any())
            ->method('listFiles')
            ->will($this->returnValue($input));

        return $mock;
    }

}
