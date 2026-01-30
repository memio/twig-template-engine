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

use Memio\Model\Phpdoc\ApiTag;
use Memio\Model\Phpdoc\DeprecationTag;
use Memio\Model\Phpdoc\Description;
use Memio\Model\Phpdoc\StructurePhpdoc;
use Memio\TwigTemplateEngine\TwigExtension\Line\LineStrategy;
use Memio\TwigTemplateEngine\TwigExtension\Line\StructurePhpdocLineStrategy;
use PhpSpec\ObjectBehavior;

class StructurePhpdocLineStrategySpec extends ObjectBehavior
{
    public function it_is_a_line_strategy()
    {
        $this->shouldImplement(LineStrategy::class);
    }

    public function it_supports_structure_phpdocs()
    {
        $structurePhpdoc = new StructurePhpdoc();

        $this->supports($structurePhpdoc)->shouldBe(true);
    }

    public function it_needs_an_empty_line_after_description_if_it_also_has_an_api_tag()
    {
        $structurePhpdoc = (new StructurePhpdoc())
            ->setDescription(new Description('helpful description'))
            ->setApiTag(new ApiTag())
        ;

        $this->needsLineAfter($structurePhpdoc, StructurePhpdocLineStrategy::DESCRPTION)->shouldBe(true);
    }

    public function it_needs_an_empty_line_after_description_if_it_also_has_a_deprecation_tag()
    {
        $structurePhpdoc = (new StructurePhpdoc())
            ->setDescription(new Description('helpful description'))
            ->setDeprecationTag(new DeprecationTag())
        ;

        $this->needsLineAfter($structurePhpdoc, StructurePhpdocLineStrategy::DESCRPTION)->shouldBe(true);
    }

    public function it_needs_an_empty_line_after_deprecation_tag_if_it_also_has_an_api_tag()
    {
        $structurePhpdoc = (new StructurePhpdoc())
            ->setDeprecationTag(new DeprecationTag())
            ->setApiTag(new ApiTag())
        ;

        $this->needsLineAfter($structurePhpdoc, StructurePhpdocLineStrategy::DEPRECATION_TAG)->shouldBe(true);
    }
}
