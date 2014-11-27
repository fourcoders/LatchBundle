<?php

namespace Fourcoders\Bundle\LatchBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Latch;

class LatchListener
{
    protected $container;
    protected $latchAppId;
    protected $latchAppSecret;

    public function __construct($container, $latchAppId, $latchAppSecret)
    {
        $this->container = $container;
        $this->latchAppId = $latchAppId;
        $this->latchAppSecret = $latchAppSecret;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $latchValue = $user->getLatch();
        if ($latchValue != '') {
            $appId = $this->latchAppId;
            $appSecret = $this->latchAppSecret;
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
