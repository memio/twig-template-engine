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

use Memio\Model\Argument;
use Memio\Model\Contract;
use Memio\Model\FullyQualifiedName;
use Memio\Model\Type as ModelType;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

class Type extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('filter_namespace', [$this, 'filterNamespace']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('has_typehint', [$this, 'hasTypehint']),
        ];
    }

    public function getTests(): array
    {
        return [
            new TwigTest('contract', [$this, 'isContract']),
        ];
    }

    public function getName(): string
    {
        return 'type';
    }

    public function isContract($model): bool
    {
        return $model instanceof Contract;
    }

    public function hasTypehint($model): bool
    {
        if (!$model instanceof Argument) {
            return false;
        }

        return $model->type->hasTypehint();
    }

    public function filterNamespace(string $stringType): string
    {
        $nullablePrefix = '?' === substr($stringType, 0, 1)
            ? '?'
            : '';

        $stringType = ltrim(ltrim($stringType, '?'));

        $type = new ModelType($stringType);
        if (!$type->isObject()) {
            return $nullablePrefix.$stringType;
        }

        $fullyQualifiedName = new FullyQualifiedName($stringType);

        return $nullablePrefix.$fullyQualifiedName->getName();
    }
}
