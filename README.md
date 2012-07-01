Esp&eacute;rance
================

master: [![Build Status](https://secure.travis-ci.org/esperance/esperance.png?branch=master)](http://travis-ci.org/esperance/esperance)
develop: [![Build Status](https://secure.travis-ci.org/esperance/esperance.png?branch=develop)](http://travis-ci.org/esperance/esperance)

BDD style assertion library for PHP.

Heavily inspired by [expect.js](https://github.com/LearnBoost/expect.js).

Usage
-----

### Installation

Esp&eacute;rance can be installed using [Composer](http://getcomposer.org/).

At first, save below as `composer.json` at the root of your project.

```
{
    "require": {
        "esperance/esperance": "dev-master"
    }
}
```

And run these commands.

```
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install
```

Then Esp&eacute;rance would be installed in `./vendor` directory and also `./vendor/autoload.php` is generated.

### Very minimal testing script by hand

Just define your `expect` method or function to construt `Esperance\Assertion` object.

```php
<?php
require './vendor/autoload.php';

function expect($obj) {
    return new \Esperance\Assertion($obj);
}

expect(1)->to->be(1);

echo "All tests passed.", PHP_EOL;
```

### PHPUnit integrtion

Use [esperance/esperance-phpunit](https://github.com/esperance/esperance-phpunit).

License
-------

The MIT License

Author
------

Yuya Takeyama
