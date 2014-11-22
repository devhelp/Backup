<?php

namespace Devhelp\Component\Backup\Provider;

use League\Flysystem\AdapterInterface;

/**
 * Class FilesystemAdapterProvider
 *
 * @author <michal@devhelp.pl>
 */
class FilesystemAdapterProvider
{
    /**
     * @var AdapterInterface
     */
    private $remoteAdapter;

    /**
     * @var AdapterInterface
     */
    private $localAdapter;

    /**
     * @param AdapterInterface $remoteAdapter
     * @param AdapterInterface $localAdapter
     */
    public function __construct(AdapterInterface $remoteAdapter, AdapterInterface $localAdapter)
    {
        $this->remoteAdapter = $remoteAdapter;
        $this->localAdapter = $localAdapter;
    }

    /**
     * @return AdapterInterface
     */
    public function getRemoteAdapter()
    {
        return $this->remoteAdapter;
    }

    /**
     * @return AdapterInterface
     */
    public function getLocalAdapter()
    {
        return $this->localAdapter;
    }

}