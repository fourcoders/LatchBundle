LatchBundle -- DEV
============================

Add in your composer.json

    {
        "require": {
            "fourcoders/latch-bundle": "dev-master"
        }
    }

Add in your app/AppKernel.php

```php
<?php

   // app/AppKernel.php
   public function registerBundles()
   {
     return array(
       // ...
       new Fourcoders\Bundle\LatchBundle\FourcodersLatchBundle(),
       // ...
     );
   }
```
Add in your app/routing.yml

    fourcoders_latch:
        resource: "@FourcodersLatchBundle/Resources/config/routing.yml"
        prefix:   /

Config the bundle in config.yml

    fourcoders_latch:
        latch_app_id: PdHF10Wnx3t3INHHZd0n
        latch_app_secret: kH1oqtVlWyWZ5UHbU1eY0HG1odd4XUIgMMLQiwag
        latch_redirect: / 

