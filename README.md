Esp&eacute;rance
================

BDD style assertion library for PHP.

Heavily inspired by [expect.js](https://github.com/LearnBoost/expect.js).

Usage
-----

### PHPUnit integration

Esperance\\PHPUnit\\TestCase class is available.

```php
<?php
class YourTestCase extends \Esperance\PHPUnit\TestCase
{
    public testSomething()
    {
        $this->expect(1 + 1)->to->be(2);
        $this->expect("foo" . "bar")->to->be("foobar")->and->not->to->be('baz');
        $this->expect(new ArrayObject)->to->be->an('ArrayObject');
        $this->expect(function () {
            throw new RuntimeException;
        })->to->throw('RuntimeException');
    }
}
```

### Intagration to the other testing framework

Just define `expect` method or function to construt Esperance\\Assertion object.

Below is a very minimal testing script by hand.

```php
<?php
function expect($obj) {
    return new \Esperance\Assertion($obj);
}

expect(1)->to->be(1);

echo "All tests passed.", PHP_EOL;
```

License
-------

The MIT License

Author
------

Yuya Takeyama
