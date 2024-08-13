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

use Memio\Model\File;
use Memio\Model\FullyQualifiedName;
use Memio\TwigTemplateEngine\TwigExtension\Line\FileLineStrategy;
use Memio\TwigTemplateEngine\TwigExtension\Line\LineStrategy;
use PhpSpec\ObjectBehavior;

class FileLineStrategySpec extends ObjectBehavior
{
    function it_is_a_line_strategy()
    {
        $this->shouldImplement(LineStrategy::class);
    }

    function it_supports_files()
    {
        $file = new File('src/Memio/Model/Contract.php');

        $this->supports($file)->shouldBe(true);
    }

    function it_needs_an_empty_line_after_use_statements()
    {
        $file = (new File('src/Memio/Model/Contract.php'))
            ->addFullyQualifiedName(new FullyQualifiedName('Memio\Model\Phpdoc\StructurePhpdoc'))
        ;

        $this->needsLineAfter($file, FileLineStrategy::USE_STATEMENTS_BLOCK)->shouldBe(true);
    }
}
