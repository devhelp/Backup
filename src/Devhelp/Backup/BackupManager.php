<?php

namespace Devhelp\Backup;

use Devhelp\Backup\Notification\NotificationInterface;

/**
 * @author <michal@devhelp.pl>
 */
class BackupManager
{
    /**
     * @var NotificationInterface
     */
    private $notification;

    /**
     * @var Backup
     */
    private $backup;

    public function __construct(Backup $backup, NotificationInterface $notification)
    {
        $this->notification = $notification;
        $this->backup = $backup;
    }

    public function runProcess()
    {

        $this->backup->run($this->notification);

    }
}
