<?php

namespace App\Services\Catalogue;

class PaymentPlanCalculator
{
    private const DEPOSIT_RATE = 0.40;

    private const FINANCED_TOTAL_MULTIPLIER = 1.50;

    private const WEEK_COUNT = 12;

    /**
     * @return array{upfront: int, weekly: int, weeks: int}|null
     */
    public function estimate(int $price): ?array
    {
        if ($price <= 0) {
            return null;
        }

        $upfront = (int) ceil($price * self::DEPOSIT_RATE);
        $financedTotal = (int) ceil(($price - $upfront) * self::FINANCED_TOTAL_MULTIPLIER);

        return [
            'upfront' => $upfront,
            'weekly' => (int) ceil($financedTotal / self::WEEK_COUNT),
            'weeks' => self::WEEK_COUNT,
        ];
    }
}
