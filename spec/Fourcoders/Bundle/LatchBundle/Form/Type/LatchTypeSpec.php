<?php

namespace spec\Fourcoders\Bundle\LatchBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;

class LatchTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\Form\Type\LatchType');
    }

    public function it_is_a_form_type()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    public function it_builds_form_with_proper_fields(FormBuilderInterface $builder)
    {
        $builder
            ->add('latch', 'text', Argument::any())
            ->willReturn($builder)
        ;

        $this->buildForm($builder, array());
    }

    public function it_has_valid_name()
    {
        $this->getName()->shouldReturn('latch_pair');
    }
}
