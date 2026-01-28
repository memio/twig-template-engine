<?php

/*
 * This file is part of the memio/twig-template-engine package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Memio\TwigTemplateEngine\TwigExtension\Line;

use Memio\Model\File;
use Memio\PrettyPrinter\Exception\InvalidArgumentException;

class FileLineStrategy implements LineStrategy
{
    const USE_STATEMENTS_BLOCK = 'fully_qualified_names';

    public function supports($model): bool
    {
        return $model instanceof File;
    }

    public function needsLineAfter($model, string $block): bool
    {
        if (self::USE_STATEMENTS_BLOCK === $block) {
            return [] !== $model->fullyQualifiedNames;
        }

        throw new InvalidArgumentException('The function needs_line_after does not support given "'.$block.'"');
    }
}
