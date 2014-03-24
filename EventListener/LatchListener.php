<?php

namespace Fourcoders\Bundle\LatchBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Fourcoders\Bundle\LatchBundle\Latch\Latch;
use Fourcoders\Bundle\LatchBundle\Latch\LatchResponse;
use Fourcoders\Bundle\LatchBundle\Latch\Error;

class LatchListener
{


    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }


    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        if (!empty($user->getLatch())) {
            $appId = $this->container->getParameter('latch_app_id');
            $appSecret = $this->container->getParameter('latch_app_secret');            
            $api = new Latch($appId, $appSecret);
            $statusResponse = $api->status($user->getLatch());
            if ($statusResponse->getError() === null) {
                if ($statusResponse->getData()->operations->$appId->status == 'off') {
                    $this->container->get('security.context')->setToken(null);
                    $this->container->get('request')->getSession()->invalidate();
                }
            } else {
                $this->container->get('security.context')->setToken(null);
                $this->container->get('request')->getSession()->invalidate();
            }  
        }    
    }
}
