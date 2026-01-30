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

use Memio\Model\Constant;
use Memio\Model\Method;
use Memio\Model\Objekt;
use Memio\Model\Property;
use Memio\TwigTemplateEngine\TwigExtension\Line\LineStrategy;
use Memio\TwigTemplateEngine\TwigExtension\Line\ObjectLineStrategy;
use PhpSpec\ObjectBehavior;

class ObjectLineStrategySpec extends ObjectBehavior
{
    public function it_is_a_line_strategy()
    {
        $this->shouldImplement(LineStrategy::class);
    }

    public function it_supports_objects()
    {
        $objekt = new Objekt('Memio\Model\Objekt');

        $this->supports($objekt)->shouldBe(true);
    }

    public function it_needs_an_empty_line_after_constants_if_it_also_has_properties()
    {
        $objekt = (new Objekt('Memio\Model\Objekt'))
            ->addConstant(new Constant('CONSTANT_ONE', 1))
            ->addProperty(new Property('filename'))
            ->addProperty(new Property('content'))
        ;

        $this->needsLineAfter($objekt, ObjectLineStrategy::CONSTANTS_BLOCK)->shouldBe(true);
    }

    public function it_needs_an_empty_line_after_constants_if_it_also_has_methods()
    {
        $objekt = (new Objekt('Memio\Model\Objekt'))
            ->addConstant(new Constant('CONSTANT_ONE', 1))
            ->addMethod(new Method('write'))
        ;

        $this->needsLineAfter($objekt, ObjectLineStrategy::CONSTANTS_BLOCK)->shouldBe(true);
    }

    public function it_needs_an_empty_line_after_properties_if_it_also_has_methods()
    {
        $objekt = (new Objekt('Memio\Model\Objekt'))
            ->addProperty(new Property('filename'))
            ->addMethod(new Method('write'))
        ;

        $this->needsLineAfter($objekt, ObjectLineStrategy::PROPERTIES_BLOCK)->shouldBe(true);
    }
}
