Assetpublisher
--------------

this is a lightweight Asset publisher.
Mostly your [assets](https://de.wikipedia.org/wiki/Medieninhalt) (images,css,java-script files) are located in project's `vendor/`-Directory or other protected folders and are not accessable for Users Webbrowser. 

The Section "assets" in the bundle-configuration provides the publish strategies. The Key `sources` defines an array of Asset-Sources. The Sources-Array Key defines the target filename.

In this Example, the bootstrap.css is copied to `%kernel.project_dir%/web/assets/style.css`:

```yaml
publicpath: "%kernel.project_dir%/web/assets"
sources:
    styles.css:
        - "%kernel.project_dir%/vendor/bootstrap/bootstrap.css"
```


Lets have a look at this configurationfile (`config/packages/assets.yml`):

```yaml
asset_publisher:
    assets:
        publicpath: "%kernel.project_dir%/web/assets"
        sources:
            # symlink: the folder "pictures" will be symlinked to web/assets/images
            images:
                - "%kernel.project_dir%/app/Resources/Views/pictures"
            # merge: asset-source are multiple files, all files will be merged into "web/assets/style.css"
            styles.css:
                - "%kernel.project_dir%/web/libs/library/extern-js/jquery-ui/jquery.tooltip.css"
                - "%kernel.project_dir%/web/libs/library/extern-js/fancybox/jquery.fancybox-1.3.4.css"
            # copy: asset-source is a single file and will be copied to web/assets/js-tree.min.css
            js-tree.min.css:
                - "%kernel.project_dir%/web/libs/library/extern-js/jstree/themes/default/style.min.css"
```

## Publish strategies

### Symlink

Create a symbolic Link from asset-source to publicpath

- source must be a Directory

### Merge

merges all Asset-source Files into on common public file.

- sources must contain at least two files

### Copy

copy the Asset-source to publicpath

- source must be a single file

# Installation

1. `composer require henryvolkmer/asset-publisher` 
2. register the bundle in your bundles.php

```php
<?php
// config/bundles.php
return [
    // ...
    Henry\AssetPublisherBundle\AssetPublisherBundle::class => ['all' => true],
```
