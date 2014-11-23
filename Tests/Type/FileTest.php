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
     * @test
     */
    public function __toString()
    {
        $file = new File("web/simple.txt");

        $this->assertEquals("web/simple.txt", $file);

        return '';
    }
} 