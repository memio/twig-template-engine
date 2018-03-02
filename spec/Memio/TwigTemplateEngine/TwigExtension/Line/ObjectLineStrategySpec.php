<?php

/*
 * This file is part of the memio/twig-template-engine package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Memio\TwigTemplateEngine\TwigExtension\Line;

use Memio\Model\Objekt;
use Memio\TwigTemplateEngine\TwigExtension\Line\LineStrategy;
use PhpSpec\ObjectBehavior;

class ObjectLineStrategySpec extends ObjectBehavior
{
    const CONSTANT_BLOCK = 'constants';
    const PROPERTY_BLOCK = 'properties';

    function it_is_a_line_strategy()
    {
        $this->shouldImplement(LineStrategy::class);
    }

    function it_supports_objects(Objekt $object)
    {
        $this->supports($object)->shouldBe(true);
    }

    function it_needs_line_after_constants_if_object_has_both_constants_and_properties(
        Objekt $object
    ) {
        $object->allConstants()->willReturn([1]);
        $object->allProperties()->willReturn([2]);
        $object->allMethods()->willReturn([]);

        $this->needsLineAfter($object, self::CONSTANT_BLOCK)->shouldBe(true);
    }

    function it_needs_line_after_constants_if_object_has_both_constants_and_methods(
        Objekt $object
    ) {
        $object->allConstants()->willReturn([1]);
        $object->allProperties()->willReturn([]);
        $object->allMethods()->willReturn([2]);

        $this->needsLineAfter($object, self::CONSTANT_BLOCK)->shouldBe(true);
    }

    function it_needs_line_after_properties_if_object_has_both_properties_and_methods(Objekt $object)
    {
        $object->allConstants()->willReturn([]);
        $object->allProperties()->willReturn([1]);
        $object->allMethods()->willReturn([2]);

        $this->needsLineAfter($object, self::PROPERTY_BLOCK)->shouldBe(true);
    }
}
