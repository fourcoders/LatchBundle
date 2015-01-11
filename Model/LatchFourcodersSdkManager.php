<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

use Fourcoders\LatchSdk\Latch;

class LatchFourcodersSdkManager extends LatchManagerBase
{
    public function setClient()
    {
        $this->latch = new Latch($this->latchAppId, $this->latchAppSecret);
    }
}
