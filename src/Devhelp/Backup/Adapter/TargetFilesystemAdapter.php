<?php

namespace Devhelp\Backup\Adapter;

/**
 * @author <michal@devhelp.pl>
 */
interface TargetFilesystemAdapter
{
    /**
     * @param string $path
     * @return bool
     */
    public function createDirectory($path);

    /**
     * @param string $path
     * @param resource $resource
     * @return false|resource
     */
    public function writeStream($path, $resource);
}
