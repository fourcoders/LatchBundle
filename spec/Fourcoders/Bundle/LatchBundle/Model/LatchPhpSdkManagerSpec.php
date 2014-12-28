<?php

namespace spec\Fourcoders\Bundle\LatchBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LatchPhpSdkManagerSpec extends ObjectBehavior
{
    public function let() {
        $this->beConstructedWith(Argument::type('string'), Argument::type('string'));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\Model\LatchPhpSdkManager');
    }
}
