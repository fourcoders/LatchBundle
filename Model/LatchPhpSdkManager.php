<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

use Fourcoders\Bundle\LatchBundle\Model\LatchManagerInterface;
use Latch;
use LatchResponse;

class LatchPhpSdkManager implements LatchManagerInterface
{
    protected $latchAppId;
    protected $latch;

    public function __construct($latchAppId,$latchAppSecret)
    {
        $this->latchAppId = $latchAppId;
        $this->latch = new Latch($latchAppId, $latchAppSecret);
    }

    public function pair($latchToken)
    {
        $response = $this->latch->pair($latchToken);

        return $response;
    }

    public function getStatusResponse($latchId)
    {
        $statusResponse = $this->latch->status($latchId);

        return $statusResponse;
    }

    public function getStatusValue(LatchResponse $statusResponse)
    {
        $appId = $this->latchAppId;

        return $statusResponse->getData()->operations->$appId->status;
    }

    public function getOperationStatus($latchId , $operationId)
    {
        $statusResponse = $this->latch->operationStatus($latchId, $operationId);

        return $statusResponse->getData()->operations->$operationId->status;
    }

    public function getOperations($operationId = null)
    {
        $response = $this->latch->getOperations();

        return $response->data->operations;
    }

    public function getOperationByName($operationName)
    {
        $operations = $this->getOperations();
        $vars=get_object_vars($operations);
        foreach ($vars as $key => $value) {
            $operationsVars  = get_object_vars($operations->$key);
            if($operationsVars["name"] === $operationName) {
                return $key;
            }
        }
    }

}
