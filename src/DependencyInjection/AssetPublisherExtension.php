<?php

namespace Henry\AssetPublisherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Henry\AssetPublisherBundle\AssetClearer;

class AssetPublisherExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        if (isset($config['assets'])) {
            $container->findDefinition(AssetClearer::class)->addMethodCall('setAssets', [$config['assets']]);
        }
    }
}
