<?php
// src/Acme/DemoBundle/Security/Authorization/Voter/ClientIpVoter.php
namespace Fourcoders\Bundle\LatchBundle\Model;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

        // si usuario tiene latch
        if (is_object($user) && $user->getLatch()) {
            $operations = $this->operations;
            $operationName = $this->findRequest( $request->getPathInfo() );
            // si existe operation verificamos estado operacion
            if ($operationName) {
                $operationId = $this->latchManager->getOperationByName($operationName);
                $operationStatus = $this->latchManager->getOperationStatus($user->getLatch(), $operationId);
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
        foreach ($this->operations as $key => $value) {
            foreach ($this->operations[$key] as $key2 => $value2) {
                if ($key2 === "pattern") {
                    if ($value2 === $pathInfo) {
                        return $this->operations[$key]["latch_operation"];
                    }
                }
            }
        }
    }
}
