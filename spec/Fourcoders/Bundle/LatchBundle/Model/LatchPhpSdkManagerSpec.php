<?php

namespace spec\Fourcoders\Bundle\LatchBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LatchPhpSdkManagerSpec extends ObjectBehavior
{
    public function let(
            $latchAppId, $latchAppSecret
        ) {
        $latchAppId = Argument::type('string');
        $latchAppSecret = Argument::type('string');
        $this->beConstructedWith($latchAppId, $latchAppSecret);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Fourcoders\Bundle\LatchBundle\Model\LatchPhpSdkManager');
    }
}
