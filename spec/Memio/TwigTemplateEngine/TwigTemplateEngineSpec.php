<?php

/*
 * This file is part of the memio/twig-template-engine package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Memio\TwigTemplateEngine;

use Memio\PrettyPrinter\TemplateEngine;
use PhpSpec\ObjectBehavior;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigTemplateEngineSpec extends ObjectBehavior
{
    const TEMPLATE_PATH = '/tmp/templates';
    const TEMPLATE = 'argument';
    const OUTPUT = '$dateTime';

    function let(Environment $twig)
    {
        $this->beConstructedWith($twig);
    }

    function it_is_a_template_engine()
    {
        $this->shouldHaveType(TemplateEngine::class);
    }

    function it_can_have_more_paths(
        Environment $twig,
        FilesystemLoader $loader
    ) {
        $twig->getLoader()->willReturn($loader);
        $loader->prependPath(self::TEMPLATE_PATH)->shouldBeCalled();

        $this->addPath(self::TEMPLATE_PATH);
    }

    function it_renders_templates_using_twig(
        Environment $twig
    ) {
        $parameters = ['name' => 'dateTime'];

        $twig->render(self::TEMPLATE.'.twig', $parameters)->willReturn(self::OUTPUT);

        $this->render(self::TEMPLATE, $parameters)->shouldBe(self::OUTPUT);
    }
}
