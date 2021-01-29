<?php

namespace App\Service;

use Symfony\Component\Config\Definition\Exception\Exception;

class CalculatorService
{
    public function index_w(float $a, float $b) {
        if ($a <= 0)
            throw new Exception('incorrect wright');

        if ($b > 2.5)
            throw new Exception('incorrect height');
        return $a / ($b * $b);
    }
}