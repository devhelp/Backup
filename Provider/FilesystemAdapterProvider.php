<?php

namespace Devhelp\Component\Backup\Provider;

use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;

/**
 * Class FilesystemAdapterProvider
 *
 * @author <michal@devhelp.pl>
 */
class FilesystemAdapterProvider
{
    /**
     * @var FilesystemInterface
     */
    private $remoteFilesystem;

    /**
     * @var AdapterInterface
     */
    private $localFilesystem;

    /**
     * @param FilesystemInterface $remoteFilesystem
     * @param AdapterInterface $localFilesystem
     */
    public function __construct(FilesystemInterface $remoteFilesystem, AdapterInterface $localFilesystem)
    {
        $this->remoteFilesystem = $remoteFilesystem;
        $this->localFilesystem = $localFilesystem;
    }

    /**
     * @return FilesystemInterface
     */
    public function getRemoteFilesystem()
    {
        return $this->remoteFilesystem;
    }

    /**
     * @return AdapterInterface
     */
    public function getLocalFilesystem()
    {
        return $this->localFilesystem;
    }

}