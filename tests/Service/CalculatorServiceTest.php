<?php


namespace App\Tests\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use App\Service\CalculatorService;

class CalculatorServiceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function index_w_normal() : void {
        $service = new CalculatorService();
        $result = $service->index_w(50, 1.58);
        $right = 20.0288415318;
        self::assertEquals($right, $result);
    }
    /**
     * @test
     */
    public function index_w_high() : void {
        $service = new CalculatorService();
        $result = $service->index_w(100, 1.6);
        $right = 39.0625;
        self::assertEquals($right, $result);
    }
    /**
     * @test
     */
    public function index_w_low() : void {
        $service = new CalculatorService();
        $result = $service->index_w(44, 1.7);
        $right = 15.2249134948;
        self::assertEquals($right, $result);
    }
    /**
     * @test
     */
    public function index_w_error() : void {
        $service = new CalculatorService();
        $this ->expectException(Exception::class);
        $service->index_w(-1, 1.5);
    }
    /**
     * @test
     */
    public function index_w_error_1() : void {
        $service = new CalculatorService();
        $this ->expectException(Exception::class);
        $service->index_w(56, 3);
    }

}