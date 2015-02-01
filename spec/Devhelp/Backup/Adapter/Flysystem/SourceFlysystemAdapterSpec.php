<?php

namespace spec\Devhelp\Backup\Adapter\Flysystem;

use League\Flysystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SourceFlysystemAdapterSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Devhelp\Backup\Adapter\Flysystem\SourceFlysystemAdapter');
        $this->shouldImplement('Devhelp\Backup\Adapter\SourceFilesystemAdapter');
    }

    function it_should_successfully_read_stream_from_remote_file($path, Filesystem $filesystem)
    {
        $filesystem->readStream($path)->willReturn('resource');
        $this->readStream($path)->shouldReturn('resource');
        $filesystem->readStream($path)->shouldBeCalled();
    }

    function it_should_unsuccessfully_read_stream_from_remote_file($path, Filesystem $filesystem)
    {
        $filesystem->readStream($path)->willReturn(false);
        $this->readStream($path)->shouldReturn(false);
        $filesystem->readStream($path)->shouldBeCalled();
    }
}
