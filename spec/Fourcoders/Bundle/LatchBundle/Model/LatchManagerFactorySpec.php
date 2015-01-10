<?php

namespace spec\Fourcoders\Bundle\LatchBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Fourcoders\Bundle\LatchBundle\Model\LatchManagerInterface;

class LatchManagerFactorySpec extends ObjectBehavior
{
    public function let(
            ContainerInterface $container,
            LatchManagerInterface $manager
        ) {
        $container->get(Argument::any())->willReturn($manager);
        $this->beConstructedWith($container, Argument::exact(Argument::any())->getValue());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\Model\LatchManagerFactory');
    }

    public function it_gets_manager()
    {
        $this->getManager()
            ->shouldReturnAnInstanceOf('Fourcoders\Bundle\LatchBundle\Model\LatchManagerInterface');
    }
}
