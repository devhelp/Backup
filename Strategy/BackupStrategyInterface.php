<?php

namespace Devhelp\Component\Backup\Strategy;

use Devhelp\Component\Backup\Type\File;

/**
 * Interface BackupStrategyInterface provides
 * files list to backup
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