<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

use Fourcoders\Bundle\LatchBundle\Model\LatchPhpSdkManager;

class LatchManagerFactory
{
    protected $container;
    protected $driver;

    public function __construct($container , $driver) {
        $this->container = $container;
        $this->driver = $driver;
    }

    public function getManager() {
        $service = ($this->driver == "eleven_paths")
            ? $this->container->get('latch_manager')
            : /* another manager*/ ;

        return $service;
    }
}