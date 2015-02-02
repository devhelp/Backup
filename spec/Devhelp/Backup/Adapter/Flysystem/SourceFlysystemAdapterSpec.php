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
        $this->shouldImplement('Devhelp\Backup\Adapter\SourceFilesystemAdapterInterface');
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

    function it_should_return_resources_list_from_source_filesystem(Filesystem $filesystem)
    {
        $filesystem->listContents('', true)->willReturn([
            ['path' => 'test/1.jpg', 'type' => 'file'],
            ['path' => 'test/2.jpg', 'type' => 'file'],
            ['path' => 'test/3.jpg', 'type' => 'file']
        ]);

        $this->getResourcesList()->shouldBeArray();
    }
}
