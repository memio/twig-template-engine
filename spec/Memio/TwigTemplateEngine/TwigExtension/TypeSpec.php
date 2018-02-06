<?php

/*
 * This file is part of the memio/twig-template-engine package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Memio\TwigTemplateEngine\TwigExtension;

use PhpSpec\ObjectBehavior;

class TypeSpec extends ObjectBehavior
{
    public function it_can_be_a_non_object()
    {
        $this->filterNamespace('int')->shouldBe('int');
    }

    public function it_can_be_a_nullable_non_object()
    {
        $this->filterNamespace('?int')->shouldBe('?int');
    }

    public function it_can_be_an_object()
    {
        $this->filterNamespace('Vendor\Project\MyClass')->shouldBe('MyClass');
    }

    public function it_can_be_a_nullable_object()
    {
        $this->filterNamespace('?Vendor\Project\MyClass')->shouldBe('?MyClass');
    }
}
