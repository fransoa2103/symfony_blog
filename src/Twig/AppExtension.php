<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('longueur', [$this, 'getLength']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('calcul', [$this, 'calculAdd']),
        ];
    }

    public function getLength(array $tab)
    {
        return "le tableau contient ".count($tab)." articles";
    }

    public function calculAdd(int $c1, int $c2)
    {
        return "la somme de ".$c1." + ".$c2." est égale à ".$c1 + $c2." , et voila !";
    }
}
