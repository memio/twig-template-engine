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

use Memio\Model\Phpdoc\MethodPhpdoc;
use Memio\Model\Phpdoc\ApiTag;
use Memio\Model\Phpdoc\Description;
use Memio\Model\Phpdoc\DeprecationTag;
use Memio\Model\Phpdoc\ParameterTag;
use Memio\TwigTemplateEngine\TwigExtension\Line\LineStrategy;
use PhpSpec\ObjectBehavior;

class MethodPhpdocLineStrategySpec extends ObjectBehavior
{
    function it_is_a_line_strategy()
    {
        $this->shouldImplement(LineStrategy::class);
    }

    function it_supports_method_phpdocs()
    {
        $methodPhpdoc = new MethodPhpdoc();

        $this->supports($methodPhpdoc)->shouldBe(true);
    }

    function it_needs_a_new_line_after_description_if_it_has_any_other_tag()
    {
        $methodPhpdoc = (new MethodPhpdoc())
            ->setDescription(new Description('Helpful description'))
            ->setDeprecationTag(new DeprecationTag())
        ;

        $this->needsLineAfter($methodPhpdoc, 'description')->shouldBe(true);
    }

    function it_needs_a_new_line_after_parameter_tags_if_it_has_a_deprecation_tag()
    {
        $methodPhpdoc = (new MethodPhpdoc())
            ->addParameterTag(new ParameterTag('string', 'filename'))
            ->setDeprecationTag(new DeprecationTag())
        ;

        $this->needsLineAfter($methodPhpdoc, 'parameter_tags')->shouldBe(true);
    }

    function it_needs_a_new_line_after_deprecation_if_it_also_has_an_api_tag()
    {
        $methodPhpdoc = (new MethodPhpdoc())
            ->setDeprecationTag(new DeprecationTag())
            ->setApiTag(new ApiTag())
        ;

        $this->needsLineAfter($methodPhpdoc, 'deprecation_tag')->shouldBe(true);
    }
}
