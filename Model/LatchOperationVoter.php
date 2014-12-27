<?php
// src/Acme/DemoBundle/Security/Authorization/Voter/ClientIpVoter.php
namespace Fourcoders\Bundle\LatchBundle\Model;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LatchOperationVoter implements VoterInterface
{
    protected $latchManager;
    protected $requestStack;
    protected $operations;

    public function __construct($latchManager, RequestStack $requestStack, array $operations = array())
    {
        $this->latchManager = $latchManager;
        $this->requestStack  = $requestStack;
        $this->operations = $operations;
    }

    public function supportsAttribute($attribute)
    {
        // you won't check against a user attribute, so return true
        return true;
    }

    public function supportsClass($class)
    {
        // your voter supports all type of token classes, so return true
        return true;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $token->getUser();

        // if user has latch
        if (is_object($user) && $user->getLatch()) {
            $operationName = $this->findRequest($request->getPathInfo());
            // if there is an operation with this pattern verify status operation
           if ($operationName) {
               $operationId = $this->latchManager->getOperationByName($operationName);
               $operationStatus = (isset($operationId))
                    ? $this->latchManager->getOperationStatus($user->getLatch(), $operationId)
                    : null;
               if ($operationStatus === "off") {
                   return VoterInterface::ACCESS_DENIED;
               }
           } else {
               return VoterInterface::ACCESS_ABSTAIN;
           }
        }

        return VoterInterface::ACCESS_ABSTAIN;
    }

    protected function findRequest($pathInfo)
    {
        $getOperation = function ($name) use ($pathInfo) {
            if ($name["pattern"] === $pathInfo) {
                return $name["latch_operation"];
            }
        };

        $getValue = function ($key, $value) {
            return $value;
        };

        return array_reduce(
            array_filter(
                array_map($getOperation, $this->operations)
            ), $getValue
        );
    }
}
