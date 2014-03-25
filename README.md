LatchBundle -- DEV
============================
Easy integration of Latch in your symfony2 project.

## Prerequisites

### Translations

If you wish to use default texts provided in this bundle, you have to make
sure you have translator enabled in your config.

``` yaml
# app/config/config.yml

framework:
    translator: ~
```

For more information about translations, check [Symfony documentation](http://symfony.com/doc/current/book/translation.html).

## Installation

1. Download LatchBundle using composer
2. Enable the Bundle
3. update your User class
4. Configure the LatchBundle
5. Import LatchBundle routing
6. Update your database schema

### Step 1: Download LatchBundle using composer

Add LatchBundle in your composer.json:

```js
{
    "require": {
        "fourcoders/latch-bundle": "dev-master"
    }
}
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Fourcoders\Bundle\LatchBundle\FourcodersLatchBundle(),
    );
}
```

### Step 3: Update your User class

### Step 4: Configure the LatchBundle

``` yaml
# app/config/config.yml
fourcoders_latch:
    latch_app_id: PdHF10WnSDasSINHHZd0n
    latch_app_secret: kH1oqtVlWyWZLKQWIJCAKLodd4XUIgMMLQiwag
    latch_redirect: / 
```

### Step 5: Import LatchBundle routing files

``` yaml
# app/config/routing.yml
fourcoders_latch:
    resource: "@FourcodersLatchBundle/Resources/config/routing.yml"
    prefix:   /
```

### Step 6: Update your database schema

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

Now that you have completed the basic installation and configuration of the
LatchBundle, you are ready to learn about more advanced features and usages
of the bundle.

The following documents are available:

- [Use into the FOSUserBundle](use_fos.md)
- [Use into the standard registration of symfony documentation](controller_events.md)
- [Overriding Templates](overriding_templates.md)
