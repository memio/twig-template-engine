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
use Memio\TwigTemplateEngine\TwigExtension\Line\Line;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Whitespace extends AbstractExtension
{
    public function __construct(private Line $line)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('needs_line_after', [$this->line, 'needsLineAfter']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('align', [$this, 'align']),
            new TwigFilter('indent', [$this, 'indent']),
        ];
    }

    public function align(string $current, array $collection): string
    {
        $elementLength = strlen($current);
        $longestElement = $elementLength;
        foreach ($collection as $element) {
            if (ParameterTag::class === $element::class) {
                $type = $element->type->getName();
                if ($element->type->isObject()) {
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
        string $type = 'code',
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
