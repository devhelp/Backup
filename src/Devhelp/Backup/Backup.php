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
        $resourcesList = $this->sourceFilesystemAdapter->getResourcesList();
        $notification->runProcess(count($resourcesList));

        foreach ($resourcesList as $resource) {
            $result = $this->backupResource($resource, $notification);

            if ($result === true) {
                $notification->notifySuccessStepProcess($resource);
            }
        }

        $notification->finishProcess();
    }

    private function backupResource(RemoteResource $remoteResource, NotificationInterface $notification)
    {
        if ($remoteResource->getType() === RemoteResource::TYPE_DIRECTORY) {
            return $this->targetFilesystemAdapter->createDirectory($remoteResource);
        }

        $fileStream = $this->sourceFilesystemAdapter->readStream($remoteResource);

        if ($fileStream === false) {
            $notification->notifyErrorReadingResources($remoteResource);

            return false;
        }

        $writeResult = $this->targetFilesystemAdapter->writeStream($remoteResource, $fileStream);
        if ($writeResult === false) {
            $notification->notifyErrorWritingResources($remoteResource);

            return false;
        }

        return true;
    }
}
