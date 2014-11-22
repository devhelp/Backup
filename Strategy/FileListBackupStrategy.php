<?php

namespace Devhelp\Component\Backup\Strategy;

use Devhelp\Component\Backup\Type\File;
use League\Flysystem\FilesystemInterface;

/**
 * Class FileListBackupStrategy
 *
 * @author <michal@devhelp.pl>
 */
class FileListBackupStrategy implements BackupStrategyInterface
{

    /**
     * @var FilesystemInterface
     */
    private $remoteFilesystem;

    /**
     * @param FilesystemInterface $remoteFilesystem
     */
    public function setRemoteAdapter(FilesystemInterface $remoteFilesystem)
    {
        $this->remoteFilesystem = $remoteFilesystem;
    }

    /**
     * @return File[]
     */
    public function getFileList()
    {
        $list = array();

        foreach ($this->remoteFilesystem->listFiles('', true) as $file) {
            $list[] = new File($file['path']);
        }

        return $list;
    }
}