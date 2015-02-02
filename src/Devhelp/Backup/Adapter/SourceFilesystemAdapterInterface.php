<?php

namespace Devhelp\Backup\Adapter;

use Devhelp\Backup\Type\RemoteResource;

/**
 * @author <michal@devhelp.pl>
 */
interface SourceFilesystemAdapterInterface
{
    /**
     * @param string $path
     * @return resource|false
     */
    public function readStream($path);

    /**
     * @return RemoteResource[]
     */
    public function getResourcesList();
}
