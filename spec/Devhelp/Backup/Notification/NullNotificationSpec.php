<?php

namespace spec\Devhelp\Backup\Notification;

use Devhelp\Backup\Type\RemoteResource;
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

    function it_should_do_nothing(RemoteResource $remoteResource, $nbOfResources)
    {
        $this->runProcess($nbOfResources)->shouldReturn(null);
        $this->finishProcess()->shouldReturn(null);
        $this->notifyErrorReadingResources($remoteResource)->shouldReturn(null);
        $this->notifyErrorWritingResources($remoteResource)->shouldReturn(null);
        $this->notifySuccessStepProcess($remoteResource)->shouldReturn(null);
    }
}
