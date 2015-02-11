<?php

namespace spec\Devhelp\Backup\Notification;

use Devhelp\Backup\BackupEvents;
use Devhelp\Backup\Type\RemoteResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author <michal@devhelp.pl>
 */
class EventDispatcherNotificationSpec extends ObjectBehavior
{

    function let(EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Devhelp\Backup\Notification\EventDispatcherNotification');
        $this->shouldImplement('Devhelp\Backup\Notification\NotificationInterface');
    }

    function it_should_notify_after_backup_process_start(EventDispatcherInterface $eventDispatcher, $nbOfResources)
    {
        $this->runProcess($nbOfResources);
        $eventDispatcher->dispatch(BackupEvents::RUN_PROCESS_EVENT)->shouldBeCalled();
    }

    function it_should_notify_after_backup_process_finish(EventDispatcherInterface $eventDispatcher)
    {
        $this->finishProcess();
        $eventDispatcher->dispatch(BackupEvents::FINISH_PROCESS_EVENT)->shouldBeCalled();
    }

    function it_should_notify_after_error_during_reading_resource(EventDispatcherInterface $eventDispatcher, RemoteResource $remoteResource)
    {
        $this->notifyErrorReadingResources($remoteResource);
        $eventDispatcher->dispatch(BackupEvents::NOTIFY_ERROR_READING_EVENT)->shouldBeCalled();
    }

    function it_should_notify_after_error_during_writing_resource(EventDispatcherInterface $eventDispatcher, RemoteResource $remoteResource)
    {
        $this->notifyErrorWritingResources($remoteResource);
        $eventDispatcher->dispatch(BackupEvents::NOTIFY_ERROR_WRITING_EVENT)->shouldBeCalled();
    }

    function it_should_notify_after_successfully_creating_resource(EventDispatcherInterface $eventDispatcher, RemoteResource $remoteResource)
    {
        $this->notifySuccessStepProcess($remoteResource);
        $eventDispatcher->dispatch(BackupEvents::NOTIFY_SUCCESS_STEP_EVENT)->shouldBeCalled();
    }

}
