# CHANGELOG

## 3.0.3: Fixed Model v3 usage

Fully update templates and Type extension to work with memio/model v3 changes:
* Public properties instead of getter methods
* Type stored as Type object instead of string

## 3.0.2: Dockerised dev environment

* setup Github Actions
* changed tooling from scripts to Makefile
* installed phpstan as a dev depdendency
* installed swiss-knife as a dev depdendency
* installed rector as a dev depdendency
* upgraded PHP CS fixer to v2.19.3
* dockerized for local development

## 3.0.1: Fixed templates

* fixed templates

## 3.0.0: PHP 7.2 requirement, PHP 8 and phpspec 7 support

* dropped support for PHP < 7.2
* added support for PHP 8
* added support for phpspec 7

## 2.0.0-alpha3: Allowed Twig v2

* added support for Twig 2

## 2.0.0-alpha2: Fixed style

* fixed method opening curly brace
* fixed property collection

## 2.0.0-alpha1: PHP 7

* dropped support for PHP < 7
* added scalar type hints
* added return type hints

### BC breaks:

* changed maximum method argument line length from 120 to 80
* changed opening curly brace to be on the same line as the method closing
  parenthesis, when arguments are on many lines
* changed properties to not have empty lines between them,
  except if they have PHPdoc

### Example

Code generated before:

```php
<?php

namespace Vendor\Project;

class MyClass
{
    private $variableNamesWouldNotBeVeryLong;
    
    private $imagineCodeWithVariableNamesThatNeverEnd;

    /**
     * @var string
     */
    private $number;

    public funtion myMethod($variableNamesWouldNotBeVeryLong, $isFirst, $thisIsTheLongestVariableNameEver)
    {
        return 42;
    }

    public function myOtherMethod()
    {
        return [];
    }
}
```

Code generated after:

```php
<?php

namespace Vendor\Project;

class MyClass
{
    private $variableNamesWouldNotBeVeryLong;
    private $imagineCodeWithVariableNamesThatNeverEnd;

    /**
     * @var string
     */
    private $number;

    public funtion myMethod(
        bool $variableNamesWouldNotBeVeryLong,
        string $isFirst,
        float $thisIsTheLongestVariableNameEver
    ) : int {
        return 42;
    }

    public function myOtherMethod() : array
    {
        return [];
    }
}
```

## 1.2.7: Allowed Twig v2

* added support for Twig 2

## 1.2.6: Fixed missing empty line

* fixed missing empty line abovr namespace

## 1.2.5: Updated dependencies

* added support for PHP 7

## 1.2.4: Fixed custom template priority

* custom templates now have a higher priority

## 1.2.3: No namespace

* do not generate namespace statement if not set

## 1.2.1: Fixed return tag

* fixed return tag

## 1.2.0: Model v1.3

* updated dependency on memio/model to v1.3

## 1.1.1: Fixed PHPdoc tags

* actually merged the PR about the new PHPdoc tags

## 1.1.0: @return and @throws PHPdoc tags

* added abstract class
* added `return` PHPdoc tag
* added `throws` PHPdoc tag

## 1.0.2: Fixed Locate namespace

* fixed Locate namespace

## 1.0.1: Fixed documentation

* fixed version in README

## 1.0.0: Stabilized

* updated documentation

## 1.0.0-rc1: Import

* imported twig template engine from [memio/pretty-printer](http://github.com/memio/pretty-printer) v1.0.0-rc5
