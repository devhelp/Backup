<?php

namespace spec\Devhelp\Backup;

use Devhelp\Backup\Notification\NotificationInterface;
use Devhelp\Backup\Adapter\SourceFilesystemAdapterInterface;
use Devhelp\Backup\Adapter\TargetFilesystemAdapterInterface;
use Devhelp\Backup\Type\RemoteResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author <michal@devhelp.pl>
 */
class BackupSpec extends ObjectBehavior
{
    function let(
        SourceFilesystemAdapterInterface $sourceFilesystemAdapter,
        TargetFilesystemAdapterInterface $targetFilesystemAdapter
    )
    {
        $this->beConstructedWith($sourceFilesystemAdapter, $targetFilesystemAdapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Devhelp\Backup\Backup');
    }

    function it_creates_backup_containing_files(
        SourceFilesystemAdapterInterface $sourceFilesystemAdapter,
        TargetFilesystemAdapterInterface $targetFilesystemAdapter,
        NotificationInterface $notification
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

        $notification->runProcess(count($resources))->shouldBeCalled();
        foreach ($resources as $resource) {
            $notification->notifySuccessStepProcess($resource)->shouldBeCalled();
        }
        $notification->finishProcess()->shouldBeCalled();
    }

    function it_creates_backup_containing_directory_and_files(
        SourceFilesystemAdapterInterface $sourceFilesystemAdapter,
        TargetFilesystemAdapterInterface $targetFilesystemAdapter,
        NotificationInterface $notification
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

        $notification->runProcess(3)->shouldBeCalled();
        foreach ($resources as $resource) {
            $notification->notifySuccessStepProcess($resource)->shouldBeCalled();
        }
        $notification->finishProcess()->shouldBeCalled();
    }

    function it_creates_backup_with_error_while_reading_resource(
        SourceFilesystemAdapterInterface $sourceFilesystemAdapter,
        TargetFilesystemAdapterInterface $targetFilesystemAdapter,
        NotificationInterface $notification
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
        $notification->runProcess(count($resources))->shouldBeCalled();
        $notification->notifyErrorReadingResources($resources[0])->shouldBeCalledTimes(1);
        $notification->notifySuccessStepProcess($resources[1])->shouldBeCalledTimes(1);
        $notification->finishProcess()->shouldBeCalled();
    }

    function it_creates_backup_with_error_while_writing_resource(
        SourceFilesystemAdapterInterface $sourceFilesystemAdapter,
        TargetFilesystemAdapterInterface $targetFilesystemAdapter,
        NotificationInterface $notification
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
        $notification->notifyErrorWritingResources($resources[1])->shouldBeCalledTimes(1);
        $notification->notifySuccessStepProcess($resources[0])->shouldBeCalledTimes(1);
        $notification->runProcess(count($resources))->shouldBeCalled();
        $notification->finishProcess()->shouldBeCalled();
    }

}
