<?php

namespace spec\Fourcoders\Bundle\LatchBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Fourcoders\Bundle\LatchBundle\Tests\LatchUser;

class LatchUserManagerSpec extends ObjectBehavior
{
    public function let(
            SecurityContextInterface $securityContext, EntityManagerInterface $entityManager
            ,UsernamePasswordToken $token ,LatchUser $latchUser
        ) {
        $securityContext->getToken()->willReturn($token);
        $token->getUser()->willReturn($latchUser);
        $this->beConstructedWith($securityContext,$entityManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\Model\LatchUserManager');
    }

    function it_gets_user_from_security_context()
    {
        $this->getUserFromSecurityContext()->shouldReturnAnInstanceOf('Fourcoders\Bundle\LatchBundle\Tests\LatchUser');
    }

    function it_pairs_latch_user()
    {
        $this->pairLatch(Argument::any());
    }

    function it_saves_user(LatchUser $user)
    {
        $user = new LatchUser();
        $user->setLatch(Argument::any());
        $this->save($user);
    }
}
