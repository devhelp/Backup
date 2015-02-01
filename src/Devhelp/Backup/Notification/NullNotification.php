<?php

namespace Devhelp\Backup\Notification;

/**
 * @author <michal@devhelp.pl>
 */
class NullNotification implements Notification
{
    public function runProcess()
    {
    }

    public function finishProcess()
    {
    }

    public function notifyErrorReadingResources()
    {
    }

    public function notifyErrorWritingResources()
    {
    }

    public function notifySuccessStepProcess()
    {
    }
}
