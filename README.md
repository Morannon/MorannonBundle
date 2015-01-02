# SMS Gateway for Symfony 2


[![Build Status](https://travis-ci.org/Morannon/MorannonBundle.svg?branch=master)](https://travis-ci.org/Morannon/MorannonBundle)
[![Latest Stable Version](https://poser.pugx.org/morannon/morannon-bundle/v/stable.png)](https://packagist.org/packages/morannon/morannon-bundle)
[![Total Downloads](https://poser.pugx.org/morannon/morannon-bundle/downloads.png)](https://packagist.org/packages/morannon/morannon-bundle)

---
 
- [Supported services](#supported-services)
- [Installation](#installation)
- [Registering the Bundle](#registering-the-bundle)
- [Configuration](#configuration)
- [Usage](#usage)

## Supported services

Included service implementations:

- Nexmo
- WhateverMobile
- more to come!

## Installation

Add morannon-bundle to your composer.json file:

```json
"require": {
  "morannon/morannon-bundle": "~0.1"
}
```

Use composer to install this package.

```
$ composer update morannon/morannon-bundle
```

### Registering the Bundle

Register the bundle in your ```app/AppKernel.php```:

```php
    new \Morannon\Bundle\MorannonBundle\MorannonBundle(),
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


Nexmo is used as an example here. Replace it with whatever your want.
Now add all the resource owners you need, the services are created automatically.

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

# Usage

For type hinting the service use the `\Morannon\Base\Gateway\GatewayInterface` interface, which provides the `sendSMS` method.
This interface can also be used as type hinting in method and constructor signatures.

## sending a sms

The `sendSMS` method expects an instance of the `Morannon\Base\SMS\SMSInterface` interface.
If you du not need any special magic, you could easily use the `Morannon\Base\SMS\BaseSMS` implementation.

It returns an instance of `Morannon\Base\Response\SentResponseInterface` interface which provides information about
the sent sms (e.g. getSentMessagesCount(), getMessageId()).