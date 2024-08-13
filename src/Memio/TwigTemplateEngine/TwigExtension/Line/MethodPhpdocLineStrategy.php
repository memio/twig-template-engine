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

use Memio\Model\Phpdoc\MethodPhpdoc;

class MethodPhpdocLineStrategy implements LineStrategy
{
    public function supports($model): bool
    {
        return $model instanceof MethodPhpdoc;
    }

    public function needsLineAfter($model, string $block): bool
    {
        $hasApiTag = (null !== $model->apiTag);
        $hasParameterTags = ([] !== $model->parameterTags);
        $hasDescription = (null !== $model->description);
        $hasDeprecationTag = (null !== $model->deprecationTag);
        $hasReturnTag = (null !== $model->returnTag);
        $hasThrowTags = ([] !== $model->throwTags);

        if ('description' === $block) {
            return $hasDescription && ($hasReturnTag || $hasApiTag || $hasDeprecationTag || $hasParameterTags || $hasThrowTags);
        }
        if ('parameter_tags' === $block) {
            return $hasParameterTags && ($hasReturnTag || $hasApiTag || $hasDeprecationTag || $hasThrowTags);
        }
        if ('deprecation_tag' === $block) {
            return $hasDeprecationTag && ($hasReturnTag || $hasApiTag || $hasThrowTags);
        }
        if ('return_tag' === $block) {
            return $hasReturnTag && ($hasApiTag || $hasThrowTags);
        }
        if ('throw_tags' === $block) {
            return $hasThrowTags && $hasApiTag;
        }
    }
}
