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
use Memio\Model\Contract;
use Memio\Model\Method;
use Memio\TwigTemplateEngine\TwigExtension\Line\ContractLineStrategy;
use Memio\TwigTemplateEngine\TwigExtension\Line\LineStrategy;
use PhpSpec\ObjectBehavior;

class ContractLineStrategySpec extends ObjectBehavior
{
    public function it_is_a_line_strategy()
    {
        $this->shouldImplement(LineStrategy::class);
    }

    public function it_supports_contracts()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'));

        $this->supports($contract)->shouldBe(true);
    }

    public function it_needs_an_empty_line_after_constants_if_it_also_has_methods()
    {
        $contract = (new Contract('Memio\PrettyPrinter\TemplateEngine'))
            ->addConstant(new Constant('CONSTANT_ONE', 1))
            ->addMethod(new Method('methodOne'))
        ;

        $this->needsLineAfter($contract, ContractLineStrategy::CONSTANTS_BLOCK)->shouldBe(true);
    }
}
