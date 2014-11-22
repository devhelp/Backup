<?php

namespace Devhelp\Component\Backup\Provider;

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
     * @var FilesystemInterface
     */
    private $localFilesystem;

    /**
     * @param FilesystemInterface $remoteFilesystem
     * @param FilesystemInterface $localFilesystem
     */
    public function __construct(FilesystemInterface $remoteFilesystem, FilesystemInterface $localFilesystem)
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
     * @return FilesystemInterface
     */
    public function getLocalFilesystem()
    {
        return $this->localFilesystem;
    }

}