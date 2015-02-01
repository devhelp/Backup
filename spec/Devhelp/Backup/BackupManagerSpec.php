<?php

namespace spec\Devhelp\Backup;

use Devhelp\Backup\Backup;
use Devhelp\Backup\Notification\Notification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author <michal@devhelp.pl>
 */
class BackupManagerSpec extends ObjectBehavior
{
    function let(Backup $backup, Notification $notification)
    {
        $this->beConstructedWith($backup, $notification);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Devhelp\Backup\BackupManager');
    }

    function it_runs_backup_process(Notification $notification, Backup $backup)
    {
        $this->runProcess();
        $backup->run($notification)->shouldBeCalled();
        $notification->runProcess()->shouldBeCalled();
        $notification->finishProcess()->shouldBeCalled();
    }
}
