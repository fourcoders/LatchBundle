<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

use Fourcoders\LatchSdk\Latch;

class LatchFourcodersSdkManager implements LatchManagerInterface
{
    protected $latchAppId;
    protected $latchAppSecret;
    protected $latch;

    public function __construct($latchAppId, $latchAppSecret)
    {
        $this->latchAppId = $latchAppId;
        $this->latchAppSecret = $latchAppSecret;
    }

    public function setClient()
    {
        $this->latch = new Latch($this->latchAppId, $this->latchAppSecret);
    }

    public function pair($latchToken)
    {
        $response = $this->latch->pair($latchToken);
        $pairResponse = $this->getDataFromPair($response);

        return $pairResponse;
    }

    protected function getDataFromPair($response)
    {
        $pairResponse = array();

        (null !== $response->getData())
            ? $pairResponse["data"]["accountId"] = $response->getData()->accountId
            : $pairResponse["error"]["message"]  = $response->getError()->getMessage();

        return $pairResponse;
    }

    public function getStatusResponse($latchId)
    {
        return $this->latch->status($latchId);
    }

    public function getStatusValue($latchId)
    {
        $appId = $this->latchAppId;

        return $this->latch->status($latchId)->getData()->operations->$appId->status;
    }

    public function getOperationStatus($latchId, $operationId)
    {
        return $this->latch->operationStatus($latchId, $operationId)->getData()->operations->$operationId->status;
    }

    public function getOperations($operationId = null)
    {
        return $this->latch->getOperations()->getData()->operations;
    }

    public function getError($latchId)
    {
        return $this->latch->status($latchId)->getError();
    }

    public function getOperationByName($operationName)
    {
        $operations = $this->getOperations();
        $vars = get_object_vars($operations);
        foreach ($vars as $key => $value) {
            $operationsVars  = get_object_vars($operations->$key);
            if ($operationsVars["name"] === $operationName) {
                return $key;
            }
        }
    }
}
