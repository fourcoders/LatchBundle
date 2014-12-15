<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

use LatchResponse;

interface LatchManagerInterface
{
    public function pair($latchToken);

    public function getStatusResponse($latchId);

    public function getStatusValue(LatchResponse $statusResponse);
}
