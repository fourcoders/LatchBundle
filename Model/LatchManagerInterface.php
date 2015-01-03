<?php

namespace Fourcoders\Bundle\LatchBundle\Model;


interface LatchManagerInterface
{
    /**
     * Pair Latch
     *
     * @param string $latchToken
     *
     * @return string[]
     */
    public function pair($latchToken);

    public function getStatusResponse($latchId);

    public function getStatusValue($latchId);

    public function getOperationStatus($latchId, $operationId);

    public function getError($latchId);

    public function getOperations($operationId = null);

    public function getOperationByName($operationName);
}
