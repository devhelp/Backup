<?php

namespace Devhelp\Backup\Notification;

use Devhelp\Backup\BackupEvents;
use Devhelp\Backup\Type\RemoteResource;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author <michal@devhelp.pl>
 */
class EventDispatcherNotification implements NotificationInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function runProcess($nbOfResources)
    {
        $this->eventDispatcher->dispatch(BackupEvents::RUN_PROCESS_EVENT);
    }

    public function finishProcess()
    {
        $this->eventDispatcher->dispatch(BackupEvents::FINISH_PROCESS_EVENT);
    }

    public function notifyErrorReadingResources(RemoteResource $remoteResource)
    {
        $this->eventDispatcher->dispatch(BackupEvents::NOTIFY_ERROR_READING_EVENT);
    }

    public function notifyErrorWritingResources(RemoteResource $remoteResource)
    {
        $this->eventDispatcher->dispatch(BackupEvents::NOTIFY_ERROR_WRITING_EVENT);
    }

    public function notifySuccessStepProcess(RemoteResource $remoteResource)
    {
        $this->eventDispatcher->dispatch(BackupEvents::NOTIFY_SUCCESS_STEP_EVENT);
    }
}
