<?php

/*
 * This file is part of the memio/twig-template-engine package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Memio\TwigTemplateEngine\TwigExtension;

use Memio\Model\FullyQualifiedName;
use Memio\Model\Phpdoc\ParameterTag;
use Memio\Model\Type as ModelType;
use Memio\TwigTemplateEngine\TwigExtension\Line\Line;

class Whitespace extends \Twig_Extension
{
    private $line;

    public function __construct(Line $line)
    {
        $this->line = $line;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('needs_line_after', [$this->line, 'needsLineAfter']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('align', [$this, 'align']),
            new \Twig_SimpleFilter('indent', [$this, 'indent']),
        ];
    }

    public function align(string $current, array $collection): string
    {
        $elementLength = strlen($current);
        $longestElement = $elementLength;
        foreach ($collection as $element) {
            if (ParameterTag::class === get_class($element)) {
                $type = $element->getType();
                $modelType = new ModelType($element->getType());
                if ($modelType->isObject()) {
                    $fullyQualifiedName = new FullyQualifiedName($type);
                    $type = $fullyQualifiedName->getName();
                }
                $longestElement = max($longestElement, strlen($type));
            }
        }

        return $current.str_repeat(' ', $longestElement - $elementLength);
    }

    public function indent(
        string $text,
        int $level = 1,
        string $type = 'code'
    ): string {
        $lines = explode("\n", $text);
        $indentedLines = [];
        if ('code' === $type) {
            foreach ($lines as $line) {
                $indentedLines[] = '    '.$line;
            }
        }
        if ('phpdoc' === $type) {
            foreach ($lines as $line) {
                $indent = ' *';
                if (!empty($line)) {
                    $indent .= ' ';
                }
                $indentedLines[] = $indent.$line;
            }
        }

        return implode("\n", $indentedLines);
    }

    public function getName(): string
    {
        return 'whitespace';
    }
}
