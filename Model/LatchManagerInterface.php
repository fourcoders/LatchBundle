<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

use LatchResponse;

interface LatchManagerInterface
{
    public function pair($latchToken);

    public function getStatusResponse($latchId);

    public function getStatusValue(LatchResponse $statusResponse);

    public function getOperationStatus($latchId, $operationId);

    public function getOperations($operationId = null);

    public function getOperationByName($operationName);
}
