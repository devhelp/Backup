<?php

namespace Devhelp\Backup\Notification;

use Devhelp\Backup\BackupEvents;
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

    public function runProcess()
    {
        $this->eventDispatcher->dispatch(BackupEvents::RUN_PROCESS_EVENT);
    }

    public function finishProcess()
    {
        $this->eventDispatcher->dispatch(BackupEvents::FINISH_PROCESS_EVENT);
    }

    public function notifyErrorReadingResources()
    {
        $this->eventDispatcher->dispatch(BackupEvents::NOTIFY_ERROR_READING_EVENT);
    }

    public function notifyErrorWritingResources()
    {
        $this->eventDispatcher->dispatch(BackupEvents::NOTIFY_ERROR_WRITING_EVENT);
    }

    public function notifySuccessStepProcess()
    {
        $this->eventDispatcher->dispatch(BackupEvents::NOTIFY_SUCCESS_STEP_EVENT);
    }
}
