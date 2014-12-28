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
            LatchManagerInterface $latchManager, RequestStack $requestStack, $operations
        ) {
        $operations = array("1" => array("pattern" => "/profile", "latch_operation" => "profile-operation"));
        $this->beConstructedWith($latchManager, $requestStack, $operations);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\Model\LatchOperationVoter');
    }

    public function it_votes_anon(TokenInterface $token, RequestStack $requestStack, Request $request)
    {
        $requestStack->getCurrentRequest()->willReturn($request);
        $token->getUser()->willReturn("anon.");
        $this->vote($token, $object = null, $attributes = array())->shouldReturn(self::ACCESS_ABSTAIN);
    }

    public function it_votes_that_user_logged_can_access_path_without_latch_operations(TokenInterface $token, RequestStack $requestStack, Request $request)
    {
        $request->getPathInfo()->willReturn(Argument::exact('/home')->getValue());
        $this->getCommonStubs($token,$requestStack,$request);
        $this->vote($token, $object = null, $attributes = array())->shouldReturn(self::ACCESS_ABSTAIN);
    }

    public function it_votes_that_user_logged_can_access_path_with_unlock_latch_operations(LatchManagerInterface $latchManager, TokenInterface $token, RequestStack $requestStack, Request $request)
    {
        $request->getPathInfo()->willReturn(Argument::exact('/profile')->getValue());
        $this->getCommonStubs($token,$requestStack,$request);
        $this->latchManagerStub($latchManager);
        $latchManager->getOperationStatus(Argument::any(), "profile-operation")->willReturn("on");
        $this->vote($token, $object = null, $attributes = array())->shouldReturn(self::ACCESS_ABSTAIN);
    }

    public function it_votes_that_user_logged_cannot_access_path_with_lock_latch_operations(LatchManagerInterface $latchManager, TokenInterface $token, RequestStack $requestStack, Request $request)
    {
        $request->getPathInfo()->willReturn(Argument::exact('/profile')->getValue());
        $this->getCommonStubs($token,$requestStack,$request);
        $this->latchManagerStub($latchManager);
        $latchManager->getOperationStatus(Argument::any(), "profile-operation")->willReturn("off");
        $this->vote($token, $object = null, $attributes = array())->shouldReturn(self::ACCESS_DENIED);
    }

    protected function getCommonStubs(TokenInterface $token, RequestStack $requestStack, Request $request)
    {
        $requestStack->getCurrentRequest()->willReturn($request);
        $latchUser = $this->getMockUser();
        $token->getUser()->willReturn($latchUser);
    }

    protected function latchManagerStub(LatchManagerInterface $latchManager)
    {
        $latchManager
            ->getOperationByName(Argument::exact("profile-operation")->getValue())
            ->willReturn(Argument::exact("profile-operation")->getValue());
    }

    protected function getMockUser()
    {
        $latchUser = new LatchUser();
        $latchUser->setLatch(Argument::any());

        return $latchUser;
    }
}
