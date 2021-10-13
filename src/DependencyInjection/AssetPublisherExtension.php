<?php

namespace Henry\AssetPublisherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Henry\AssetPublisherBundle\AssetClearer;

class AssetPublisherExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        if (isset($config['assets'])) {
            $container->findDefinition(AssetClearer::class)->addMethodCall('setAssets', [$config['assets']]);
        }
    }
}
