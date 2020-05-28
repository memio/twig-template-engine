<?php

/*
 * This file is part of the memio/twig-template-engine package.
 *
 * (c) Loïc Faugeron <faugeron.loic@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Memio\TwigTemplateEngine;

use Memio\PrettyPrinter\TemplateEngine;
use Twig\Environment;

class TwigTemplateEngine implements TemplateEngine
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function addPath(string $path)
    {
        $this->twig->getLoader()->prependPath($path);
    }

    public function render(string $template, array $parameters = []): string
    {
        return $this->twig->render($template.'.twig', $parameters);
    }
}
