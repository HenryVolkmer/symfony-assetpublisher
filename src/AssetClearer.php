<?php

namespace Henry\AssetPublisherBundle;

use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use array_key_exists;

class AssetClearer implements CacheClearerInterface
{
    private array $assets = [];

    public function clear(string $cacheDirectory)
    {
        if (array_key_exists('publicpath', $this->assets) && array_key_exists('sources', $this->assets)) {
            $this->composeAssets($this->assets['publicpath'], $this->assets['sources']);
        }
    }

    public function setAssets(array $assets)
    {
        $this->assets = $assets;
    }

    public function addSources(array $sources)
    {
        if (!isset($this->assets['sources'])) {
            $this->assets['sources'] = [];
        }
        $this->assets['sources'] = array_merge($this->assets['sources'], $sources);
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
