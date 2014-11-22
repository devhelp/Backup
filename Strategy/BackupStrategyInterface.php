<?php

namespace Devhelp\Component\Backup\Strategy;

use Devhelp\Component\Backup\Type\File;

/**
 * Interface BackupStrategyInterface provides
 * files list to backup
 *
 * @package Devhelp\Component\Backup
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