<?php

namespace Devhelp\Component\Backup\Strategy;

use Devhelp\Component\Backup\Type\File;

/**
 * Class FileBackupStrategy
 * @author <michal@devhelp.pl>
 */
class FileBackupStrategy implements BackupStrategyInterface
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return File[]
     */
    public function getFileList()
    {
        return array(
            new File($this->filePath)
        );
    }
}