<?php

namespace spec\Devhelp\Backup\Notification;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author <michal@devhelp.pl>
 */
class NullNotificationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Devhelp\Backup\Notification\NullNotification');
        $this->shouldImplement('Devhelp\Backup\Notification\NotificationInterface');
    }

    function it_should_do_nothing()
    {
        $this->runProcess()->shouldReturn(null);
        $this->finishProcess()->shouldReturn(null);
        $this->notifyErrorReadingResources()->shouldReturn(null);
        $this->notifyErrorWritingResources()->shouldReturn(null);
        $this->notifySuccessStepProcess()->shouldReturn(null);
    }
}
