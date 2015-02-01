<?php

namespace Devhelp\Backup;

use Devhelp\Backup\Notification\Notification;

/**
 * @author <michal@devhelp.pl>
 */
class BackupManager
{
    /**
     * @var Notification
     */
    private $notification;

    /**
     * @var Backup
     */
    private $backup;

    public function __construct(Backup $backup, Notification $notification)
    {
        $this->notification = $notification;
        $this->backup = $backup;
    }

    public function runProcess()
    {
        $this->notification->runProcess();
        $this->backup->run($this->notification);
        $this->notification->finishProcess();
    }
}
