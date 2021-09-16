<?php

namespace Henry\AssetPublisherBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

class AssetPublisherExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        /**
         * compose assets
         */
        if (isset($config['assets'])) {
            $this->composeAssets(
                $config['assets']['publicpath'],
                $config['assets']['sources']
            );
        }
    }

    private function composeAssets($assetFolder, array $sources=[])
    {
        $filesystem = new Filesystem();
        $filesystem->remove([$assetFolder]);
        $filesystem->mkdir($assetFolder);

        foreach ($sources as $destName => $assetSources) {
            if (!$assetSources) {
                continue;
            }

            $assetTarget = $assetFolder . "/" . $destName;

            $content = '';
            foreach ($assetSources as $assetSource) {
                if (is_dir($assetSource)) {
                    $filesystem->symlink($assetSource, $assetTarget, true);
                    if (!is_dir($assetTarget)) {
                        throw new IOException(sprintf('Symbolic link "%s" was created but appears to be broken.', $assetTarget), 0, null, $assetTarget);
                    }
                    continue;
                }

                $content .= "/*" . $assetSource . "*/\n\n" . file_get_contents($assetSource);
            }

            if (!file_exists($assetTarget) && !empty($content)) {
                $filesystem->dumpFile($assetTarget, $content);
            }
        }
    }
}
