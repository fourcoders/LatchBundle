<?php

namespace spec\Fourcoders\Bundle\LatchBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Request;
use Fourcoders\Bundle\LatchBundle\Tests\LatchUser;

class LatchUserManagerSpec extends ObjectBehavior
{
    public function let(
            SecurityContextInterface $securityContext,
            EntityManagerInterface $entityManager,
            Request $request,
            UsernamePasswordToken $token,
            LatchUser $latchUser
        ) {
        $securityContext->getToken()->willReturn($token);
        $token->getUser()->willReturn($latchUser);
        $this->beConstructedWith($securityContext, $entityManager, $request);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\Model\LatchUserManager');
    }

    public function it_gets_user_from_security_context()
    {
        $this->getUserFromSecurityContext()->shouldReturnAnInstanceOf('Fourcoders\Bundle\LatchBundle\Tests\LatchUser');
    }

    public function it_pairs_latch_user()
    {
        $this->pairLatch(Argument::any());
    }

    public function it_throws_an_exception_user_must_be_logged_before_pair(UsernamePasswordToken $token)
    {
        $token->getUser()->willReturn(null);
        $this->shouldThrow(new \Exception("User must be logged before pair with Latch"))->duringPairLatch(Argument::any());
    }

    public function it_saves_user(LatchUser $user)
    {
        $user = new LatchUser();
        $user->setLatch(Argument::any());
        $this->save($user);
    }
}
