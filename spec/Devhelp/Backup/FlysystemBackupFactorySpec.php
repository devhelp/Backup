<?php

namespace spec\Devhelp\Backup;

use Devhelp\Backup\Notification\NotificationInterface;
use League\Flysystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author <michal@devhelp.pl>
 */
class FlysystemBackupFactorySpec extends ObjectBehavior
{
    function let(Filesystem $source, Filesystem $target)
    {
        $this->beConstructedWith($source, $target);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Devhelp\Backup\FlysystemBackupFactory');
        $this->shouldImplement('Devhelp\Backup\BackupFactoryInterface');
    }

    function it_should_create_backup_manager(NotificationInterface $notification)
    {
        $this->create($notification)->shouldReturnAnInstanceOf('Devhelp\Backup\BackupManager');
    }
}
