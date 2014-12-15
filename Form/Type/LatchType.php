<?php

namespace Fourcoders\Bundle\LatchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class LatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('latch', 'text', array(
                'attr' => array('class' => 'latch', 'placeholder' => ''),
                'required' => true,
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
        ;
    }

    public function getName()
    {
        return '';
    }
}
