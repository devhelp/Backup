<?php

namespace Devhelp\Backup\Adapter\Flysystem;

use Devhelp\Backup\Adapter\TargetFilesystemAdapter;
use League\Flysystem\FileExistsException;
use League\Flysystem\Filesystem;

/**
 * @author <michal@devhelp.pl>
 */
class TargetFlysystemAdapter implements TargetFilesystemAdapter
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function createDirectory($path)
    {
        return $this->filesystem->createDir($path);
    }

    public function writeStream($path, $resource)
    {
        try {
            return $this->filesystem->writeStream($path, $resource);
        } catch (FileExistsException $exception) {
            return $this->filesystem->updateStream($path, $resource);
        }
    }
}
