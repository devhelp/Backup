<?php

namespace Devhelp\Backup;

use Devhelp\Backup\Adapter\Flysystem\SourceFlysystemAdapter;
use Devhelp\Backup\Adapter\Flysystem\TargetFlysystemAdapter;
use Devhelp\Backup\Notification\NotificationInterface;
use League\Flysystem\Filesystem;

/**
 * @author <michal@devhelp.pl>
 */
class FlysystemBackupFactory implements BackupFactoryInterface
{
    /**
     * @var Filesystem
     */
    private $source;
    /**
     * @var Filesystem
     */
    private $target;

    public function __construct(Filesystem $source, Filesystem $target)
    {
        $this->source = $source;
        $this->target = $target;
    }

    public function create(NotificationInterface $notification)
    {
        $source = new SourceFlysystemAdapter($this->source);
        $target = new TargetFlysystemAdapter($this->target);
        $backup = new Backup($source, $target);

        return new BackupManager($backup, $notification);
    }
}
