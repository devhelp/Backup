<?php

namespace spec\Devhelp\Backup\Type;

use Devhelp\Backup\Type\RemoteResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author <michal@devhelp.pl>
 */
class RemoteResourceSpec extends ObjectBehavior
{

    function it_is_initializable($path, $type)
    {
        $this->beConstructedWith($path, $type);
        $this->shouldHaveType('Devhelp\Backup\Type\RemoteResource');
    }

    function it_should_return_to_string_for_file_resource()
    {
        $this->beConstructedWith('test/1.jpg');
        $this->__toString()->shouldReturn('test/1.jpg');
    }

    function it_should_return_to_string_for_directory_resource()
    {
        $this->beConstructedWith('test', 'dir');
        $this->__toString()->shouldReturn('test');
    }

    function it_should_return_name_for_file_resource()
    {
        $this->beConstructedWith('test/1.jpg');
        $this->getName()->shouldReturn('1');
    }

    function it_should_return_name_for_directory_resource()
    {
        $this->beConstructedWith('test', 'dir');
        $this->getName()->shouldReturn('test');
    }

    function it_should_return_dir_name_for_file_resource()
    {
        $this->beConstructedWith('test/1.jpg');
        $this->getDirName()->shouldReturn('test');
    }

    function it_should_return_dir_name_for_directory_resource()
    {
        $this->beConstructedWith('test', 'dir');
        $this->getDirName()->shouldReturn('test');
    }

    function it_should_return_basename_for_file_resource()
    {
        $this->beConstructedWith('/test/1.jpg');
        $this->getBasename()->shouldReturn('1.jpg');
    }

    function it_should_return_basename_for_directory_resource()
    {
        $this->beConstructedWith('test', 'dir');
        $this->getBasename()->shouldReturn('test');
    }

    function it_should_return_extension_for_file_resource()
    {
        $this->beConstructedWith('test/1.jpg');
        $this->getExtension()->shouldReturn('jpg');
    }

    function it_should_return_extension_for_directory_resource()
    {
        $this->beConstructedWith('test', 'dir');
        $this->getExtension()->shouldReturn('');
    }

    function it_should_successfully_compare_two_resources()
    {
        $resource = new RemoteResource('test/1.jpg');
        $this->beConstructedWith('test/1.jpg');

        $this->equals($resource)->shouldReturn(true);
    }

    function it_should_unsuccessfully_compare_two_resources()
    {
        $resource = new RemoteResource('test/2.jpg');
        $this->beConstructedWith('test/1.jpg');


        $this->equals($resource)->shouldReturn(false);
    }
}
