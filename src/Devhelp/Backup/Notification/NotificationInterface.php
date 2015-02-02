<?php

namespace Devhelp\Backup\Notification;

/**
 * @author <michal@devhelp.pl>
 */
interface NotificationInterface
{
    /**
     * It runs when backup process has started
     */
    public function runProcess();

    /**
     * It runs when backup process has finished
     */
    public function finishProcess();

    /**
     * It runs when source file system cannot read a resource
     */
    public function notifyErrorReadingResources();

    /**
     * It runs when target file system cannot write resource
     */
    public function notifyErrorWritingResources();

    /**
     * It runs when target file system successfully write resource
     */
    public function notifySuccessStepProcess();
}
