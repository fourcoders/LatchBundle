<?php

namespace Fourcoders\Bundle\LatchBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LatchListener
{
    protected $container;
    protected $latchFactory;

    public function __construct($container, $latchFactory)
    {
        $this->container = $container;
        $this->latchFactory = $latchFactory;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $latchValue = $user->getLatch();

        if (!empty($latchValue)) {
            $manager = $this->latchFactory->getManager();
            $statusResponse = $manager->getStatusResponse($latchValue);
            if ($statusResponse->getError() != null
                || $manager->getStatusValue($statusResponse) == 'off' ) {
                    $this->container->get('security.context')->setToken(null);
                    $this->container->get('request')->getSession()->invalidate();
            }
        }
    }
}
