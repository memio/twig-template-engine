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
use Memio\Model\Contract;

class ContractLineStrategy implements LineStrategy
{
    public function supports($model) : bool
    {
        return $model instanceof Contract;
    }

    public function needsLineAfter($model, string $block) : bool
    {
        $constants = $model->allConstants();
        $methods = $model->allMethods();
        if ('constants' === $block) {
            return !empty($constants) && !empty($methods);
        }

        throw new InvalidArgumentException('The function needs_line_after does not support given "'.$block.'"');
    }
}
