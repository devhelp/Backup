<?php

namespace Devhelp\Component\Backup\Strategy;

use Devhelp\Component\Backup\Type\File;

/**
 * Interface provides files list to create backup
 *
 * @author <michal@devhelp.pl>
 */
interface BackupStrategyInterface
{
    /**
     * Get file list to backup
     *
     * @return File[]
     */
    public function getFileList();
}
