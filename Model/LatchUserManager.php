<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

class LatchUserManager
{
    protected $em;
    protected $securityContext;

    public function __construct($securityContext, $entityManager)
    {
        $this->securityContext = $securityContext;
        $this->em = $entityManager;
    }

    public function getUserFromSecurityContext()
    {
        return $this->securityContext->getToken()->getUser();
    }

    public function pairLatch($latchId)
    {
        $user = $this->getUserFromSecurityContext();
        $user->setLatch($latchId);
        $this->save($user);
    }

    public function unpairLatch($latchId)
    {
        $user = $this->getUserFromSecurityContext();
        $user->setLatch(null);
        $this->save($user);
    }

    public function save($user)
    {
        $em = $this->em;
        $em->persist($user);
        $em->flush();
    }
}
