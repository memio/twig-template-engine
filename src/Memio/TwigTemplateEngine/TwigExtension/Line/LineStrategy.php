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

interface LineStrategy
{
    public function supports($model) : bool;

    /**
     * @throws InvalidArgumentException If the block isn't supported
     */
    public function needsLineAfter($model, string $block) : bool;
}
