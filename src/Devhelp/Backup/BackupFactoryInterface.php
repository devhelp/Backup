<?php

namespace Devhelp\Backup;

use Devhelp\Backup\Notification\NotificationInterface;

/**
 * @author <michal@devhelp.pl>
 */
interface BackupFactoryInterface
{
    /**
     * @param NotificationInterface $notification
     * @return BackupManager
     */
    public function create(NotificationInterface $notification);
}