<?php

namespace Devhelp\Backup;

use Devhelp\Backup\Notification\Notification;
use Devhelp\Backup\Adapter\SourceFilesystemAdapter;
use Devhelp\Backup\Adapter\TargetFilesystemAdapter;
use Devhelp\Backup\Type\RemoteResource;

/**
 * @author <michal@devhelp.pl>
 */
class Backup
{
    /**
     * @var SourceFilesystemAdapter
     */
    private $sourceFilesystemAdapter;
    /**
     * @var TargetFilesystemAdapter
     */
    private $targetFilesystemAdapter;

    public function __construct(
        SourceFilesystemAdapter $sourceFilesystemAdapter,
        TargetFilesystemAdapter $targetFilesystemAdapter
    )
    {
        $this->sourceFilesystemAdapter = $sourceFilesystemAdapter;
        $this->targetFilesystemAdapter = $targetFilesystemAdapter;
    }

    public function run(Notification $notification)
    {
        foreach ($this->sourceFilesystemAdapter->getResourcesList() as $resource) {
            $result = $this->backupResource($resource, $notification);

            if ($result === true) {
                $notification->notifySuccessStepProcess();
            }
        }
    }

    private function backupResource(RemoteResource $remoteResource, Notification $notification)
    {
        if ($remoteResource->getType() === RemoteResource::TYPE_DIRECTORY) {
            return $this->targetFilesystemAdapter->createDirectory($remoteResource);
        }

        $fileStream = $this->sourceFilesystemAdapter->readStream($remoteResource);

        if ($fileStream === false) {
            $notification->notifyErrorReadingResources();

            return false;
        }

        $writeResult = $this->targetFilesystemAdapter->writeStream($remoteResource, $fileStream);
        if ($writeResult === false) {
            $notification->notifyErrorWritingResources();

            return false;
        }

        return true;
    }
}
