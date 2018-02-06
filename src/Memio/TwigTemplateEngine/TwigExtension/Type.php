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

class Type extends \Twig_Extension
{
    public function getFilters() : array
    {
        return [
            new \Twig_SimpleFilter('filter_namespace', [$this, 'filterNamespace']),
        ];
    }

    public function getFunctions() : array
    {
        return [
            new \Twig_SimpleFunction('has_typehint', [$this, 'hasTypehint']),
        ];
    }

    public function getTests() : array
    {
        return [
            new \Twig_SimpleTest('contract', [$this, 'isContract']),
        ];
    }

    public function getName() : string
    {
        return 'type';
    }

    public function isContract($model) : bool
    {
        return $model instanceof Contract;
    }

    public function hasTypehint($model) : bool
    {
        if (!$model instanceof Argument) {
            return false;
        }
        $type = new ModelType($model->getType());

        return $type->hasTypehint();
    }

    public function filterNamespace(string $stringType) : string
    {
        $nullablePrefix = substr($stringType, 0, 1) === '?'
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
