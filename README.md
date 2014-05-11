# Premailer Bundle

This is a Symfony2 bundle for the [Premailer](https://github.com/premailer/premailer/) project that uses the [Premailer CLI](https://github.com/premailer/premailer/wiki/Premailer-Command-Line-Usage) (command line interface).

## Prerequisites

You will have to install the [Premailer gem](https://github.com/premailer/premailer/#installation) as per the official instructions. At the time of writing, the following snippet works properly on a Ubuntu 12.04 LTS installation:

```bash
sudo apt-get install ruby-dev
sudo gem install premailer nokogiri
```

## Installation

### Download the bundle

If you are using [Composer](https://getcomposer.org/) as your package manager, you can simply use:

```bash
composer require wecodepixels/premailer-bundle:dev-master
```

Or if you prefer to manually edit your **composer.json** file:

```json
{
    "require": {
	    "wecodepixels/premailer-bundle": "dev-master"
    }
}
```

and then run `composer update wecodepixels/premailer-bundle`.

### Enable the bundle

Add the bundle inside your **AppKernel.php** file:

```php
<?php
// app/AppKernel.php

registerBundles()
{
    $bundles = array(
        // ...
		new WeCodePixels\PremailerBundle\WeCodePixelsPremailerBundle(),
    );
}
```

### Required configuration

You will have to specify the Premailer binary inside your **config.yml** file (or **config_dev.yml**, **config_prod.yml**, etc.). Again, here is an example that works properly on a Ubuntu 12.04 LTS installation:

```yml
we_code_pixels_premailer:
    bin: /usr/bin/premailer
```

As a tip, you can locate your **premailer** binary by executing `where premailer` inside your console.

## Usage

Here is a simple example:

```php
$html = '<h1>My HTML which contains one or more style tags</h1>';
$premailer = $this->container->get('we_code_pixels_premailer.premailer');
$premailer->setRemoveClasses(true);
$htmlWithInlinedCss = $premailer->execute($html);
```

There are a few more setters available that are directly linked to the [Premailer CLI options](https://github.com/premailer/premailer/wiki/Premailer-Command-Line-Usage):

* setMode
* setBaseUrl
* setQueryString
* setCss
* setRemoveClasses
* setRemoveScripts
* setLineLength
* setEntities
* setIoExceptions
