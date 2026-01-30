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

use Memio\Model\Argument;
use Memio\PrettyPrinter\Exception\InvalidArgumentException;
use Memio\TwigTemplateEngine\TwigExtension\Line\LineStrategy;
use PhpSpec\ObjectBehavior;

class LineSpec extends ObjectBehavior
{
    public function it_executes_the_first_strategy_that_supports_given_model(
        LineStrategy $lineStrategy,
    ) {
        $this->add($lineStrategy);

        $model = new Argument('string', 'filename');
        $block = 'arguments';
        $strategyReturn = true;

        $lineStrategy->supports($model)->willReturn(true);
        $lineStrategy->needsLineAfter($model, $block)->willReturn($strategyReturn);

        $this->needsLineAfter($model, $block)->shouldBe($strategyReturn);
    }

    public function it_fails_when_no_strategy_supports_given_model(
        LineStrategy $lineStrategy,
    ) {
        $this->add($lineStrategy);

        $model = new Argument('string', 'filename');

        $lineStrategy->supports($model)->willReturn(false);

        $this->shouldThrow(
            InvalidArgumentException::class,
        )->duringNeedsLineAfter($model, 'arguments');
    }
}
