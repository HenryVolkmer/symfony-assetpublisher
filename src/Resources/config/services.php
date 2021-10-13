<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Henry\AssetPublisherBundle\AssetClearer;

return function (ContainerConfigurator $configurator) {
    /**
     * @var ServicesConfigurator
     */
    $services = $configurator->services();
    $services->set(AssetClearer::class)
        ->tag('kernel.cache_clearer')
    ;
};
