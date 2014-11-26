<?php

namespace Devhelp\Component\Backup;

use Devhelp\Component\Backup\Event\BackupEvent;
use Devhelp\Component\Backup\Provider\FilesystemAdapterProvider;
use Devhelp\Component\Backup\Strategy\BackupStrategyInterface;
use Devhelp\Component\Backup\Type\File;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class BackupRunner is responsible for run backup
 *
 * @author <michal@devhelp.pl>
 */
class Backup
{
    /**
     * @var FilesystemAdapterProvider
     */
    private $filesystemAdapterProvider;

    /**
     * @var BackupStrategyInterface
     */
    private $strategy;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var BackupEvent
     */
    protected $backupEvent;

    /**
     * @param FilesystemAdapterProvider $filesystemAdapterProvider
     * @param BackupStrategyInterface $strategy
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        FilesystemAdapterProvider $filesystemAdapterProvider,
        BackupStrategyInterface $strategy,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->filesystemAdapterProvider = $filesystemAdapterProvider;
        $this->strategy = $strategy;
        $this->eventDispatcher = $eventDispatcher;
        $this->backupEvent = new BackupEvent($this->strategy->count());
    }

    /**
     * Run backup
     */
    public function runBackup()
    {
        $this->eventDispatcher->dispatch(BackupEvents::RUN_PROCESS, $this->backupEvent);

        foreach ($this->strategy->getFileList() as $file) {
            $result = $this->backupFile($file);

            if ($result === true) {
                $this->eventDispatcher->dispatch(BackupEvents::STEP_PROCESS, $this->backupEvent);
            }
        }

        $this->eventDispatcher->dispatch(BackupEvents::FINISH_PROCESS, $this->backupEvent);
    }

    /**
     * @param File $file
     * @return bool
     */
    protected function backupFile(File $file)
    {
        /** @var resource $fileStream */
        $fileStream = $this
            ->filesystemAdapterProvider
            ->getRemoteFilesystem()
            ->readStream($file);

        if ($fileStream === false) {
            $this->eventDispatcher->dispatch(BackupEvents::ERROR_READ_RESOURCE, $this->backupEvent);

            return false;
        }

        $writeResult = $this->filesystemAdapterProvider
            ->getLocalFilesystem()
            ->writeStream($file, $fileStream);

        if ($writeResult === false) {
            $this->eventDispatcher->dispatch(BackupEvents::ERROR_WRITE_RESOURCE, $this->backupEvent);

            return false;
        }

        return true;
    }
}
