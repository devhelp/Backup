<?php

namespace spec\Devhelp\Backup\Adapter\Flysystem;

use League\Flysystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TargetFlysystemAdapterSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Devhelp\Backup\Adapter\Flysystem\TargetFlysystemAdapter');
        $this->shouldImplement('Devhelp\Backup\Adapter\TargetFilesystemAdapterInterface');
    }

    function it_should_successfully_create_directory($path, Filesystem $filesystem)
    {
        $filesystem->createDir($path)->willReturn(true);
        $this->createDirectory($path)->shouldReturn(true);
        $filesystem->createDir($path)->shouldBeCalled();
    }

    function it_should_unsuccessfully_create_directory($path, Filesystem $filesystem)
    {
        $filesystem->createDir($path)->willReturn(false);
        $this->createDirectory($path)->shouldReturn(false);
        $filesystem->createDir($path)->shouldBeCalled();
    }

    function it_should_successfully_write_stream($path, Filesystem $filesystem)
    {
        $filesystem->writeStream($path, 'resource')->willReturn(true);
        $this->writeStream($path, 'resource')->shouldReturn(true);
        $filesystem->writeStream($path, 'resource')->shouldBeCalled();
    }

    function it_should_successfully_update_stream($path, Filesystem $filesystem)
    {
        $filesystem->writeStream($path, 'resource2')->willThrow('League\Flysystem\FileExistsException');
        $filesystem->updateStream($path, 'resource2')->willReturn(true);
        $this->writeStream($path, 'resource2');
        $filesystem->writeStream($path, 'resource2')->shouldBeCalled();
        $filesystem->updateStream($path, 'resource2')->shouldBeCalled();
    }
}
