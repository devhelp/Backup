<?php

namespace spec\Devhelp\Backup;

use Devhelp\Backup\Notification\Notification;
use Devhelp\Backup\Adapter\SourceFilesystemAdapter;
use Devhelp\Backup\Adapter\TargetFilesystemAdapter;
use Devhelp\Backup\Type\RemoteResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author <michal@devhelp.pl>
 */
class BackupSpec extends ObjectBehavior
{
    function let(
        SourceFilesystemAdapter $sourceFilesystemAdapter,
        TargetFilesystemAdapter $targetFilesystemAdapter
    )
    {
        $this->beConstructedWith($sourceFilesystemAdapter, $targetFilesystemAdapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Devhelp\Backup\Backup');
    }

    function it_creates_backup_containing_files(
        SourceFilesystemAdapter $sourceFilesystemAdapter,
        TargetFilesystemAdapter $targetFilesystemAdapter,
        Notification $notification
    )
    {
        $resources = [
            new RemoteResource('test/1.jpg'),
            new RemoteResource('test/2.jpg'),
            new RemoteResource('test/3.jpg')
        ];

        $sourceFilesystemAdapter->getResourcesList()->willReturn($resources);

        foreach ($resources as $resource) {
            $sourceFilesystemAdapter->readStream($resource)->willReturn('resource');
            $targetFilesystemAdapter->writeStream($resource, 'resource')->willReturn('resource');
        }

        $this->run($notification);
        $notification->notifySuccessStepProcess()->shouldBeCalledTimes(3);
    }

    function it_creates_backup_containing_directory_and_files(
        SourceFilesystemAdapter $sourceFilesystemAdapter,
        TargetFilesystemAdapter $targetFilesystemAdapter,
        Notification $notification
    )
    {
        $resources = [
            new RemoteResource('test', RemoteResource::TYPE_DIRECTORY),
            new RemoteResource('test/2.jpg'),
            new RemoteResource('test/3.jpg')
        ];

        $sourceFilesystemAdapter->getResourcesList()->willReturn($resources);
        $targetFilesystemAdapter->createDirectory($resources[0])->willReturn([]);
        unset($resources[0]);
        foreach ($resources as $resource) {
            $sourceFilesystemAdapter->readStream($resource)->willReturn('resource');
            $targetFilesystemAdapter->writeStream($resource, 'resource')->willReturn('resource');
        }
        $this->run($notification);
        $notification->notifySuccessStepProcess()->shouldBeCalledTimes(2);
    }

    function it_creates_backup_with_error_while_reading_resource(
        SourceFilesystemAdapter $sourceFilesystemAdapter,
        TargetFilesystemAdapter $targetFilesystemAdapter,
        Notification $notification
    )
    {
        $resources = [
            new RemoteResource('test/1.jpg'),
            new RemoteResource('test/2.jpg')
        ];

        $sourceFilesystemAdapter->getResourcesList()->willReturn($resources);
        $sourceFilesystemAdapter->readStream($resources[0])->willReturn(false);
        $sourceFilesystemAdapter->readStream($resources[1])->willReturn('resource');
        $targetFilesystemAdapter->writeStream($resources[1], 'resource')->willReturn('resource');
        $this->run($notification);
        $notification->notifyErrorReadingResources()->shouldBeCalledTimes(1);
        $notification->notifySuccessStepProcess()->shouldBeCalledTimes(1);
    }

    function it_creates_backup_with_error_while_writing_resource(
        SourceFilesystemAdapter $sourceFilesystemAdapter,
        TargetFilesystemAdapter $targetFilesystemAdapter,
        Notification $notification
    )
    {
        $resources = [
            new RemoteResource('test/1.jpg'),
            new RemoteResource('test/2.jpg')
        ];

        $sourceFilesystemAdapter->getResourcesList()->willReturn($resources);
        $sourceFilesystemAdapter->readStream($resources[0])->willReturn('resource');
        $sourceFilesystemAdapter->readStream($resources[1])->willReturn('resource');
        $targetFilesystemAdapter->writeStream($resources[0], 'resource')->willReturn('resource');
        $targetFilesystemAdapter->writeStream($resources[1], 'resource')->willReturn(false);
        $this->run($notification);
        $notification->notifyErrorWritingResources()->shouldBeCalledTimes(1);
        $notification->notifySuccessStepProcess()->shouldBeCalledTimes(1);
    }

}
