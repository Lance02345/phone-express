<?php

namespace Tests\Unit;

use App\Services\Catalogue\PaymentPlanCalculator;
use PHPUnit\Framework\TestCase;

class PaymentPlanCalculatorTest extends TestCase
{
    public function test_it_returns_one_consistent_payment_estimate(): void
    {
        $estimate = (new PaymentPlanCalculator)->estimate(100000);

        $this->assertSame([
            'upfront' => 40000,
            'weekly' => 7500,
            'weeks' => 12,
        ], $estimate);
    }

    public function test_it_does_not_quote_a_plan_without_a_published_price(): void
    {
        $this->assertNull((new PaymentPlanCalculator)->estimate(0));
    }
}
