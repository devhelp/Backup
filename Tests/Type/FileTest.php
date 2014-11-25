<?php

namespace Devhelp\Component\Backup\Tests\Type;

use Devhelp\Component\Backup\Type\File;

/**
 * Class FileTest
 *
 * @author <michal@devhelp.pl>
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function equals()
    {
        $file1 = new File("/web/simple1.txt");
        $file2 = new File("/web/simple2.txt");
        $this->assertEquals(false, $file1->equals($file2));

        $file2 = new File("/web/simple1.txt");
        $this->assertEquals(true, $file1->equals($file2));
    }

    /**
     * Without annotations here
     */
    public function testGetName()
    {
        $file = new File("/web/test/index.html");

        $this->assertEquals("index", $file->getName());
    }

    /**
     * @test
     */
    public function getBasename()
    {
        $file = new File("/web/test/index.html");

        $this->assertEquals("index.html", $file->getBasename());
    }


    /**
     * @test
     */
    public function getExtension()
    {
        $file = new File("/web/test/index.html");

        $this->assertEquals("html", $file->getExtension());
    }

    /**
     * @test
     */
    public function getDirName()
    {
        $file = new File("/web/test/index.html");

        $this->assertEquals("/web/test", $file->getDirName());
    }

    /**
     * @test
     */
    public function __toString()
    {
        $file = new File("web/simple.txt");

        $this->assertEquals("web/simple.txt", $file);

        return '';
    }
} 