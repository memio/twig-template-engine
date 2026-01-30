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

class Line
{
    private $strategies = [];

    public function add(LineStrategy $lineStrategy)
    {
        $this->strategies[] = $lineStrategy;
    }

    /**
     * @throws InvalidArgumentException If no strategy supports the given model
     */
    public function needsLineAfter($model, string $block): bool
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($model)) {
                return $strategy->needsLineAfter($model, $block);
            }
        }

        throw new InvalidArgumentException('No strategy supports given model '.$model::class);
    }
}
