<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

use Latch;

class LatchPhpSdkManager extends LatchManagerBase
{
    public function setClient()
    {
        $this->latch = new Latch($this->latchAppId, $this->latchAppSecret);
    }
}
