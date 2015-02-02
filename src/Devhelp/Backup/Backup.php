<?php

namespace Devhelp\Backup;

use Devhelp\Backup\Notification\NotificationInterface;
use Devhelp\Backup\Adapter\SourceFilesystemAdapterInterface;
use Devhelp\Backup\Adapter\TargetFilesystemAdapterInterface;
use Devhelp\Backup\Type\RemoteResource;

/**
 * @author <michal@devhelp.pl>
 */
class Backup
{
    /**
     * @var SourceFilesystemAdapterInterface
     */
    private $sourceFilesystemAdapter;
    /**
     * @var TargetFilesystemAdapterInterface
     */
    private $targetFilesystemAdapter;

    public function __construct(
        SourceFilesystemAdapterInterface $sourceFilesystemAdapter,
        TargetFilesystemAdapterInterface $targetFilesystemAdapter
    )
    {
        $this->sourceFilesystemAdapter = $sourceFilesystemAdapter;
        $this->targetFilesystemAdapter = $targetFilesystemAdapter;
    }

    public function run(NotificationInterface $notification)
    {
        foreach ($this->sourceFilesystemAdapter->getResourcesList() as $resource) {
            $result = $this->backupResource($resource, $notification);

            if ($result === true) {
                $notification->notifySuccessStepProcess();
            }
        }
    }

    private function backupResource(RemoteResource $remoteResource, NotificationInterface $notification)
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
