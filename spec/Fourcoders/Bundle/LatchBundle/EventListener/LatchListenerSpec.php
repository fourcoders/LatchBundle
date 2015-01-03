<?php

namespace spec\Fourcoders\Bundle\LatchBundle\EventListener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Fourcoders\Bundle\LatchBundle\Model\LatchManagerFactory;
use Fourcoders\Bundle\LatchBundle\Tests\LatchUser;
use Fourcoders\Bundle\LatchBundle\Model\LatchManagerInterface;
use Fourcoders\Bundle\LatchBundle\Model\LatchUserManager;
use LatchResponse;

class LatchListenerSpec extends ObjectBehavior
{
    protected $user;

    public function let(
            LatchManagerFactory $latchFactory,
            InteractiveLoginEvent $event,
            LatchUser $user,
            UsernamePasswordToken $token,
            LatchManagerFactory $latchFactory,
            LatchManagerInterface $latchManager,
            LatchResponse $latchResponse,
            LatchUserManager $latchUserManager
        ) {
        $event->getAuthenticationToken()->willReturn($token);
        $this->user = $this->getMockUser();
        $token->getUser()->willReturn($this->user);
        $latchFactory->getManager()->willReturn($latchManager);
        $latchManager->getStatusResponse(Argument::any())->willReturn($latchResponse);
        $this->beConstructedWith($latchUserManager, $latchFactory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\EventListener\LatchListener');
    }

    public function it_user_login_without_latch(InteractiveLoginEvent $event)
    {
        $this->user->setLatch(null);
        $this->onSecurityInteractiveLogin($event);
    }

    public function it_user_login_with_unlock_latch(InteractiveLoginEvent $event, LatchManagerInterface $latchManager, LatchResponse $latchResponse)
    {
        $latchManager->getStatusValue(Argument::any())->willReturn('on');
        $latchManager->getError(Argument::any())->willReturn(null);
        $this->onSecurityInteractiveLogin($event);
    }

    public function it_user_login_with_lock_latch(InteractiveLoginEvent $event, LatchManagerInterface $latchManager, LatchResponse $latchResponse, LatchUserManager $latchUserManager)
    {
        $latchManager->getStatusValue(Argument::any())->willReturn('off');
        $latchManager->getError(Argument::any())->willReturn(null);
        $latchUserManager->unsetUser()->shouldBeCalled();
        $this->onSecurityInteractiveLogin($event);
    }

    protected function getMockUser()
    {
        $latchUser = new LatchUser();
        $latchUser->setLatch(Argument::any());

        return $latchUser;
    }
}
