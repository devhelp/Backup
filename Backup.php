<?php

namespace Devhelp\Component\Backup;

use Devhelp\Component\Backup\Provider\FilesystemAdapterProvider;
use Devhelp\Component\Backup\Strategy\BackupStrategyInterface;
use Devhelp\Component\Backup\Type\File;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;

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
     * @param FilesystemAdapterProvider $filesystemAdapterProvider
     * @param BackupStrategyInterface $strategy
     */
    public function __construct(
        FilesystemAdapterProvider $filesystemAdapterProvider,
        BackupStrategyInterface $strategy
    )
    {
        $this->filesystemAdapterProvider = $filesystemAdapterProvider;
        $this->strategy = $strategy;

    }

    /**
     * Run backup
     */
    public function runBackup()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addListener();

        $dispatcher->dispatch('test.test', new GenericEvent('test', array(1)));

        foreach ($this->strategy->getFileList() as $file) {
            $this->backupFile($file);
        }
    }

    /**
     * @param File $file
     */
    protected function backupFile(File $file)
    {
        $local = $this->filesystemAdapterProvider->getLocalFilesystem();
        $remote = $this->filesystemAdapterProvider->getRemoteFilesystem();
        /** @var resource $fileStream */
        $fileStream = $remote->readStream($file);
        $local->writeStream($file, $fileStream);
    }
}
