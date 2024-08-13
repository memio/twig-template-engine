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

use Memio\PrettyPrinter\Exception\InvalidArgumentException;
use Memio\Model\Objekt;

class ObjectLineStrategy implements LineStrategy
{
    const CONSTANTS_BLOCK = 'constants';
    const PROPERTIES_BLOCK = 'properties';

    public function supports($model): bool
    {
        return $model instanceof Objekt;
    }

    public function needsLineAfter($model, string $block): bool
    {
        if (self::CONSTANTS_BLOCK === $block) {
            return [] !== $model->constants && ([] !== $model->properties || [] !== $model->methods);
        }
        if (self::PROPERTIES_BLOCK === $block) {
            return [] !== $model->properties && [] !== $model->methods;
        }

        throw new InvalidArgumentException('The function needs_line_after does not support given "'.$block.'"');
    }
}
