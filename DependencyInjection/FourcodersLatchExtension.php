<?php

namespace Fourcoders\Bundle\LatchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FourcodersLatchExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('latch_app_id', $config['latch_app_id']);
        $container->setParameter('latch_app_secret', $config['latch_app_secret']);
        $container->setParameter('latch_driver', $config['latch_app_secret']);
        $container->setParameter('latch_redirect', $config['latch_redirect']);
        $loader = new Loader\XMLFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
