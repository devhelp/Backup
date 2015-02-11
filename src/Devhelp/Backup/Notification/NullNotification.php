<?php

namespace Devhelp\Backup\Notification;

use Devhelp\Backup\Type\RemoteResource;

/**
 * @author <michal@devhelp.pl>
 */
class NullNotification implements NotificationInterface
{

    public function finishProcess()
    {
    }

    public function notifyErrorReadingResources(RemoteResource $remoteResource)
    {
    }

    public function notifyErrorWritingResources(RemoteResource $remoteResource)
    {
    }

    public function notifySuccessStepProcess(RemoteResource $remoteResource)
    {
    }

    public function runProcess($nbOfResources)
    {

    }
}
