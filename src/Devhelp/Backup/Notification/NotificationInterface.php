<?php

namespace Devhelp\Backup\Notification;

use Devhelp\Backup\Type\RemoteResource;

/**
 * @author <michal@devhelp.pl>
 */
interface NotificationInterface
{
    /**
     * It runs when backup process has started
     *
     * @param $nbOfResources
     * @return
     */
    public function runProcess($nbOfResources);

    /**
     * It runs when backup process has finished
     */
    public function finishProcess();

    /**
     * It runs when source file system cannot read a resource
     *
     * @param RemoteResource $remoteResource
     * @return
     */
    public function notifyErrorReadingResources(RemoteResource $remoteResource);

    /**
     * It runs when target file system cannot write resource
     *
     * @param RemoteResource $remoteResource
     * @return
     */
    public function notifyErrorWritingResources(RemoteResource $remoteResource);

    /**
     * It runs when target file system successfully write resource
     *
     * @param RemoteResource $remoteResource
     * @return
     */
    public function notifySuccessStepProcess(RemoteResource $remoteResource);
}
