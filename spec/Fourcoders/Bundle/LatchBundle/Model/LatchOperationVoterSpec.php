<?php

namespace spec\Fourcoders\Bundle\LatchBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Fourcoders\Bundle\LatchBundle\Model\LatchManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Fourcoders\Bundle\LatchBundle\Tests\LatchUser;

class LatchOperationVoterSpec extends ObjectBehavior
{
    const ACCESS_ABSTAIN = 0;
    const ACCESS_DENIED = -1;

    public function let(
            LatchManagerInterface $latchManager, RequestStack $requestStack, $operations,
            TokenInterface $token, Request $request
        ) {
        $operations = array("1" => array("pattern" => "/profile", "latch_operation" => "profile-operation"));
        $requestStack->getCurrentRequest()->willReturn($request);
        $latchUser = $this->getMockUser();
        $token->getUser()->willReturn($latchUser);
        $latchManager
            ->getOperationByName(Argument::exact("profile-operation")->getValue())
            ->willReturn(Argument::exact("profile-operation")->getValue());
        $this->beConstructedWith($latchManager, $requestStack, $operations);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\Model\LatchOperationVoter');
    }

    public function it_votes_anon(TokenInterface $token)
    {
        $token->getUser()->willReturn("anon.");
        $this->vote($token, $object = null, $attributes = array())->shouldReturn(self::ACCESS_ABSTAIN);
    }

    public function it_votes_that_user_logged_can_access_path_without_latch_operations(TokenInterface $token,Request $request)
    {
        $request->getPathInfo()->willReturn(Argument::exact('/home')->getValue());
        $this->vote($token, $object = null, $attributes = array())->shouldReturn(self::ACCESS_ABSTAIN);
    }

    public function it_votes_that_user_logged_can_access_path_with_unlock_latch_operations(TokenInterface $token,Request $request, LatchManagerInterface $latchManager)
    {
        $request->getPathInfo()->willReturn(Argument::exact('/profile')->getValue());
        $latchManager->getOperationStatus(Argument::any(), "profile-operation")->willReturn("on");
        $this->vote($token, $object = null, $attributes = array())->shouldReturn(self::ACCESS_ABSTAIN);
    }

    public function it_votes_that_user_logged_cannot_access_path_with_lock_latch_operations(TokenInterface $token,Request $request,LatchManagerInterface $latchManager)
    {
        $request->getPathInfo()->willReturn(Argument::exact('/profile')->getValue());
        $latchManager->getOperationStatus(Argument::any(), "profile-operation")->willReturn("off");
        $this->vote($token, $object = null, $attributes = array())->shouldReturn(self::ACCESS_DENIED);
    }

    protected function getMockUser()
    {
        $latchUser = new LatchUser();
        $latchUser->setLatch(Argument::any());

        return $latchUser;
    }
}
