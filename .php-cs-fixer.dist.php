<?php

/**
 * PHP CS Fixer documentation:
 * - Homepage: https://cs.symfony.com/
 * - List of all available rules: https://cs.symfony.com/doc/rules/index.html
 * - List of all available rule sets: https://cs.symfony.com/doc/ruleSets/index.html
 * - Find / Compare / See History rules: https://mlocati.github.io/php-cs-fixer-configurator
 *
 * To inspect a specific rule (e.g. `blank_line_before_statement`), run:
 *
 * ```console
 * > php-cs-fixer describe blank_line_before_statement
 * ```
 *
 * ------------------------------------------------------------------------------
 *
 * `new \PhpCsFixer\Finder()` is equivalent to:
 *
 * ```php
 * \Symfony\Component\Finder\Finder::create()
 *     ->files()
 *     ->name('/\.php$/')
 *     ->exclude('vendor')
 *     ->ignoreVCSIgnored(true) // Follow rules establish in .gitignore
 *     ->ignoreDotFiles(false) // Do not ignore files starting with `.`, like `.php-cs-fixer-dist.php`
 * ;
 * ```
 */
$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->ignoreDotFiles(false)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,

        // [Symfony] defaults to `camelCase`, we set it to `snake_case` (phpspec style)
        'php_unit_method_casing' => ['case' => 'snake_case'],

        // [Symfony] defaults to `['elements' => ['const', 'method', 'property']]`
        // We exclude `method` for phpspec (no visibility keyword)
        // We exclude `const` because we support PHP 7.3 (const visibility is optional)
        'modifier_keywords' => ['elements' => ['property']],

        // [Symfony] defaults to `['elements' => ['arguments', 'arrays', 'parameters']]`
        // We exclude `parameters` because we support PHP 7.3 (trailing comma in declarations requires PHP 8.0)
        'trailing_comma_in_multiline' => ['elements' => ['arguments', 'arrays']],
    ])
    ->setUsingCache(true)
    ->setFinder($finder)
;
