<?php

namespace Fourcoders\Bundle\LatchBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LatchListener
{
    protected $latchUserManager;
    protected $latchFactory;

    public function __construct($latchUserManager, $latchFactory)
    {
        $this->latchUserManager = $latchUserManager;
        $this->latchFactory = $latchFactory;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $latchValue = $user->getLatch();

        if (!empty($latchValue)) {
            $manager = $this->latchFactory->getManager();
            if ($manager->getError($latchValue) !== null
                || $manager->getStatusValue($latchValue) == 'off') {
                $this->latchUserManager->unsetUser();
            }
        }
    }
}
