<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

class LatchUserManager
{
    protected $em;
    protected $securityContext;
    protected $request;

    public function __construct($securityContext, $entityManager, $request)
    {
        $this->securityContext = $securityContext;
        $this->em = $entityManager;
        $this->request = $request;
    }

    public function getUserFromSecurityContext()
    {
        return $this->securityContext->getToken()->getUser();
    }

    public function pairLatch($latchId)
    {
        $user = $this->getUserFromSecurityContext();
        if (method_exists($user, 'setLatch')) {
            $user->setLatch($latchId);
            $this->save($user);
        } else {
            throw new \Exception('User must be logged before pair with Latch');
        }
    }

    public function unsetUser()
    {
        $this->securityContext->setToken(null);
        $this->request->getSession()->invalidate();
    }

    public function save($user)
    {
        $em = $this->em;
        $em->persist($user);
        $em->flush();
    }
}
