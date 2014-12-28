<?php

namespace Fourcoders\Bundle\LatchBundle\Tests;

class LatchUser
{
    protected $id;

    /**
     * @var string $latch
     *
     */
    private $latch;

    /**
     * Set latch
     *
     * @param string $latch
     */
    public function setLatch($latch)
    {
        $this->latch = $latch;
    }

    /**
     * Get latch
     *
     * @return string
     */
    public function getlatch()
    {
        return $this->latch;
    }
}
