<?php

namespace Devhelp\Backup\Adapter\Flysystem;

use Devhelp\Backup\Adapter\SourceFilesystemAdapterInterface;
use Devhelp\Backup\Type\RemoteResource;
use League\Flysystem\Filesystem;

/**
 * @author <michal@devhelp.pl>
 */
class SourceFlysystemAdapter implements SourceFilesystemAdapterInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function readStream($path)
    {
        return $this->filesystem->readStream($path);
    }

    public function getResourcesList()
    {
        $resourcesToBackup = array();
        $filesystemContents = $this->filesystem->listContents('', true);

        foreach ($filesystemContents as $content) {
            $resourcesToBackup[] = new RemoteResource($content['path'], $content['type']);
        }

        return $resourcesToBackup;
    }
}
