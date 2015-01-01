# SMS Gateway for Symfony 2


[![Build Status](https://api.travis-ci.org/apinnecke/MorannonBundle.png?branch=master)](https://travis-ci.org/APinneckeMorannon)
[![Latest Stable Version](https://poser.pugx.org/apinnecke/morannon-bundle/v/stable.png)](https://packagist.org/packages/apinnecke/morannon-bundle)
[![Total Downloads](https://poser.pugx.org/apinnecke/morannon-bundle/downloads.png)](https://packagist.org/packages/apinnecke/morannon-bundle)

---
 
- [Supported services](#supported-services)
- [Installation](#installation)
- [Registering the Bundle](#registering-the-bundle)
- [Configuration](#configuration)
- [Usage](#usage)
- [Basic usage](#basic-usage)
- [More usage examples](#more-usage-examples)

## Supported services

Included service implementations:

- Nexmo
- WhateverMobile
- more to come!

## Installation

Add morannon-bundle to your composer.json file:

```json
"require": {
  "apinnecke/morannon-bundle": "~0.1"
}
```

Use composer to install this package.

```
$ composer update apinnecke/morannon-bundle
```

### Registering the Bundle

Register the bundle in your ```app/AppKernel.php```:

```php
    new Morannon\Bundle\MorannonBundle\MorannonBundle(),
```

## Configuration

Now add required config to ```app/config/config.yml```: 

```yaml
morannon:
    gateways:
        nexmo:
            api_base_url: https://rest.nexmo.com
            api_user: thisismyapiuser
            api_token: thisismyapitoken
```


Nexmo is used as an example here. Replace it with whatever your want. Now add all the resource owners you need, the services are created automatically.

# Services

Services will be created automatically by this bundle. In my case, i want the xing service:
 
```php
    $service = $this->container->get('morannon.gateways.nexmo');
```

or inject it into another service:

```php
    fancy_company.random_namespace.wayne_bundle:
        class: FancyCompany\Bundle\WayneBundle\MyCool\ClassFor\WorldDominance
        arguments:
            - @morannon.gateways.nexmo
```
