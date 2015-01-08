[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b3b57288-43e2-41ec-9210-9d927071f5eb/big.png)](https://insight.sensiolabs.com/projects/b3b57288-43e2-41ec-9210-9d927071f5eb)

[![Build Status](https://travis-ci.org/fourcoders/LatchBundle.svg?branch=master)](https://travis-ci.org/fourcoders/LatchBundle) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fourcoders/LatchBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fourcoders/LatchBundle/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/fourcoders/LatchBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/fourcoders/LatchBundle/?branch=master)

LatchBundle
============================
Easy integration of Latch in your symfony2 project. 
You can visit the official website: [http://fourcoders.github.io/LatchBundle/](http://fourcoders.github.io/LatchBundle/)

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

1. [Download LatchBundle using composer](#step-1-download-latchbundle-using-composer)
2. [Enable the Bundle](#step-2-enable-the-bundle)
3. [Update your User class](#step-3-update-your-user-class)
4. [Configure the LatchBundle](#step-4-configure-the-latchbundle)
5. [Import LatchBundle routing](#step-5-import-latchbundle-routing-files)
6. [Update your database schema](#step-6-update-your-database-schema)
7. [Setup your latch operations](#step-7-setup-your-latch-operations)

### Step 1: Download LatchBundle using composer

Add LatchBundle in your composer.json. LatchBundle requires the official Latch PHP SDK by ElevenPaths.
[Composer can not load repositories recursively](https://getcomposer.org/doc/faqs/why-can%27t-composer-load-repositories-recursively.md) .You need to add this dependency in your composer.json or You can manage it by satis or toran proxy.

```js
{
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "elevenpaths/latch-sdk-php",
                "version": "dev-master",
                "source": {
                    "url": "https://github.com/ElevenPaths/latch-sdk-php.git",
                    "type": "git",
                    "reference": "origin/master"
                },
            "autoload": {
                "classmap": ["/"]
                }
            }
        }
    ],
    "require": {
        "elevenPaths/latch-sdk-php": "dev-master",
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

Insert a new field in the User entity, or whatever you are using with your security provider. 

If you are using FOSUserBundle this a example:

``` php
<?php
// src/Acme/UserBundle/Entity/User.php
namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /* Start of the new field */

    /**
     * @var string $latch
     *
     * @ORM\Column(name="latch", type="string", length=255, nullable=true)
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

    /* End of the new field */ 

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

For a stardard register, check [Symfony documentation](http://symfony.com/doc/current/cookbook/doctrine/registration_form.html), after you can override the User.php.

``` php
<?php
// src/Acme/AccountBundle/Entity/User.php
namespace Acme\AccountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max = 4096)
     */
    protected $plainPassword;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /* Start of the new field */

    /**
     * @ORM\Column(name="latch", type="string", length=255, nullable=true)
     */
    private $latch;    

    public function setLatch($latch)
    {
        $this->latch = $latch;
    }

    public function getlatch()
    {
        return $this->latch;
    }   

    /* End of the new field */ 

}
```


### Step 4: Configure the LatchBundle

``` yaml
# app/config/config.yml
fourcoders_latch:
    latch_app_id: PdHF10WnSDasSINHHZd0n
    latch_app_secret: kH1oqtVlWyWZLKQWIJCAKLodd4XUIgMMLQiwag
    latch_driver: eleven_paths
    latch_redirect: /
    latch_operations: ~
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

### Step 7: Setup your latch operations

You can securize any http resource with your Latch operations.
Begin the setup process of your operations with your operation name and pattern in the config.yml

``` yaml
# app/config/config.yml
fourcoders_latch:
    latch_app_id: PdHF10WnSDasSINHHZd0n
    latch_app_secret: kH1oqtVlWyWZLKQWIJCAKLodd4XUIgMMLQiwag
    latch_driver: eleven_paths
    latch_redirect: /
    latch_operations:
        operation1:
            pattern: "/profile"
            latch_operation : "profile-operation"
        operation2:
            pattern: "/transfer"
            latch_operation: "transfer-operation"
```

Finally your operations must be defined in the access control params:

``` yaml
# app/config/security.yml
    access_control:
        - { path: ^/transfer$, role: ROLE_USER }
        - { path: ^/profile$, role: ROLE_USER }
```

Now that you have completed the basic installation and configuration of the
LatchBundle, you are ready to learn about more advanced features and usages
of the bundle.

The following documents are available:

- [Use into the FOSUserBundle](/Resources/doc/use_fos.md)
- [Use into the standard registration of symfony documentation](/Resources/doc/use_standard.md)
- [Overriding Templates](/Resources/doc/overriding_templates.md)

