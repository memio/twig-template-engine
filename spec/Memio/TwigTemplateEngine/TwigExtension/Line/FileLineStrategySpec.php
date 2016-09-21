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
use Memio\TwigTemplateEngine\TwigExtension\Line\LineStrategy;
use PhpSpec\ObjectBehavior;

class FileLineStrategySpec extends ObjectBehavior
{
    const IMPORT_BLOCK = 'fully_qualified_names';

    function it_is_a_line_strategy()
    {
        $this->shouldImplement(LineStrategy::class);
    }

    function it_supports_files(File $file)
    {
        $this->supports($file)->shouldBe(true);
    }

    function it_needs_line_after_fully_qualified_names_if_file_has_fully_qualified_names(
        File $file
    ) {
        $file->allFullyQualifiedNames()->willReturn([1]);

        $this->needsLineAfter($file, self::IMPORT_BLOCK)->shouldBe(true);
    }
}
