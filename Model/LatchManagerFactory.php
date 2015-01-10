<?php

namespace Fourcoders\Bundle\LatchBundle\Model;

class LatchManagerFactory
{
    protected $container;
    protected $driver;

    public function __construct($container, $driver)
    {
        $this->container = $container;
        $this->driver = $driver;
    }

    public function getManager()
    {
        return ($this->driver == "eleven_paths")
            ? $this->container->get('latch_manager')
            : $this->container->get('fourcoders_manager');
    }
}
