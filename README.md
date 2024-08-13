# Memio's TwigTemplateEngine

Memio is a highly opinionated PHP code generator library. It is composed of small
independent packages, one being `PrettyPrinter`: the actual code generator.

`PrettyPrinter` relies on an interface, `TemplateEngine`, but doesn't provide any
implementation to avoid direct coupling to any templating libraries.

This package, `TwigTemplateEngine`, provides an implementation and templates for
[Twig](http://twig.sensiolabs.org).

> **Note**: This package is part of [Memio](http://memio.github.io/memio).
> Have a look at [the main repository](http://github.com/memio/memio).

## Installation

Install it using [Composer](https://getcomposer.org/download):

```console
composer require memio/twig-template-engine:^3.0
```

## Example

We're going to generate a class with a constructor and two attributes:

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Memio\Model\File;
use Memio\Model\Objekt;
use Memio\Model\Property;
use Memio\Model\Method;
use Memio\Model\Argument;

// Initialize the code generator
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
$twig = new \Twig\Environment($loader);

$line = new Memio\TwigTemplateEngine\TwigExtension\Line\Line();
$line->add(new Memio\TwigTemplateEngine\TwigExtension\Line\ContractLineStrategy());
$line->add(new Memio\TwigTemplateEngine\TwigExtension\Line\FileLineStrategy());
$line->add(new Memio\TwigTemplateEngine\TwigExtension\Line\MethodPhpdocLineStrategy());
$line->add(new Memio\TwigTemplateEngine\TwigExtension\Line\ObjectLineStrategy());
$line->add(new Memio\TwigTemplateEngine\TwigExtension\Line\StructurePhpdocLineStrategy());

$twig->addExtension(new Memio\TwigTemplateEngine\TwigExtension\Type());
$twig->addExtension(new Memio\TwigTemplateEngine\TwigExtension\Whitespace($line));

$templateEngine = new Memio\TwigTemplateEngine\TwigTemplateEngine($twig);
$prettyPrinter = new Memio\PrettyPrinter\PrettyPrinter($templateEngine);

// Describe the code you want to generate using "Models"
$myService = (new File('src/Vendor/Project/MyService.php'))
    ->setStructure(
        (new Objekt('Vendor\Project\MyService'))
            ->addProperty(new Property('createdAt'))
            ->addProperty(new Property('filename'))
            ->addMethod(
                (new Method('__construct'))
                    ->addArgument(new Argument('DateTime', 'createdAt'))
                    ->addArgument(new Argument('string', 'filename'))
            )
    )
;

// Generate the code and display in the console
echo $prettyPrinter->generateCode($myService);

// Or display it in a browser
// echo '<pre>'.htmlspecialchars($prettyPrinter->generateCode($myService)).'</pre>';
```

With this simple example, we get the following output:

```php
<?php

namespace Vendor\Project;

class MyService
{
    private $createdAt;
    private $filename;

    public function __construct(DateTime $createdAt, string $filename)
    {
    }
}
```

Have a look at [the main respository](http://github.com/memio/memio) to discover the full power of Memio.

## Want to know more?

Memio uses [phpspec](http://phpspec.net/), which means the tests also provide the documentation.
Not convinced? Then clone this repository and run the following commands:

```console
$ composer install
$ ./vendor/bin/phpspec run -n -f pretty
```

You can see the current and past versions using one of the following:

* the `git tag` command
* the [releases page on Github](https://github.com/memio/twig-template-engine/releases)
* the file listing the [changes between versions](CHANGELOG.md)

And finally some meta documentation:

* [copyright and MIT license](LICENSE)
* [versioning and branching models](VERSIONING.md)
* [contribution instructions](CONTRIBUTING.md)
