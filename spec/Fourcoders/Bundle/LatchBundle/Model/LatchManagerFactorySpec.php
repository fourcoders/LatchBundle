<?php

namespace spec\Fourcoders\Bundle\LatchBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Fourcoders\Bundle\LatchBundle\Model\LatchManagerInterface;


class LatchManagerFactorySpec extends ObjectBehavior
{
    public function let(
            ContainerInterface $container ,
            $driver,
            LatchManagerInterface $manager
        ) {
        $container->get(Argument::any())->willReturn($manager);
        $driver = Argument::exact('eleven_paths');
        $this->beConstructedWith($container, $driver->getValue());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\Model\LatchManagerFactory');
    }

    function it_gets_manager()
    {
        $this->getManager()
            ->shouldReturnAnInstanceOf('Fourcoders\Bundle\LatchBundle\Model\LatchManagerInterface');
    }
}
