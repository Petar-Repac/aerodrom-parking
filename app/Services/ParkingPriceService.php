<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\ParkingPrice;
use App\Models\ParkingSetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class ParkingPriceService
{
    public const MIN_DAYS = 1;
    public const MAX_DAYS = 40;
    public const EXTRA_DAY_RATE_KEY = 'extra_day_rate';

    /**
     * Current prices, keyed by number of days, plus the long-stay per-day
     * rate. Falls back to the config file if the database is empty or
     * unreachable, so the public site never breaks because of this feature.
     */
    public function getPrices(): array
    {
        try {
            $prices = $this->currentDbPrices();
            $extraDayRate = ParkingSetting::getValue(self::EXTRA_DAY_RATE_KEY);

            if (empty($prices) || $extraDayRate === null) {
                throw new RuntimeException('Parking prices are not seeded yet.');
            }

            return [
                'prices' => $prices,
                'extra_day_rate' => (int) $extraDayRate,
            ];
        } catch (Throwable $e) {
            Log::warning('Falling back to default parking prices', ['error' => $e->getMessage()]);

            return config('parking_prices');
        }
    }

    /**
     * Same data as getPrices(), shaped as a list of {days, price} for the
     * public reservation.js pricing calculator.
     */
    public function getPricesList(): array
    {
        $data = $this->getPrices();

        $list = [];
        foreach ($data['prices'] as $days => $price) {
            $list[] = ['days' => $days, 'price' => $price];
        }

        return $list;
    }

    /**
     * @param array<int, int> $newPrices days => price, must cover exactly 1-40
     */
    public function updatePrices(array $newPrices, int $newExtraDayRate, ?User $actor): array
    {
        $this->assertCompleteDayRange($newPrices);

        return $this->applyPrices(
            $newPrices,
            $newExtraDayRate,
            $actor,
            'price.update',
            'Updated parking prices',
        );
    }

    /**
     * The killswitch: revert every price and the long-stay rate to the
     * values in config/parking_prices.php.
     */
    public function resetToDefault(?User $actor): array
    {
        $defaults = config('parking_prices');

        return $this->applyPrices(
            $defaults['prices'],
            $defaults['extra_day_rate'],
            $actor,
            'price.reset_default',
            'Reset parking prices to defaults',
        );
    }

    private function applyPrices(
        array $newPrices,
        int $newExtraDayRate,
        ?User $actor,
        string $action,
        string $description,
    ): array {
        return DB::transaction(function () use ($newPrices, $newExtraDayRate, $actor, $action, $description) {
            $currentPrices = $this->currentDbPrices();
            $currentExtraDayRate = (int) (
                ParkingSetting::getValue(self::EXTRA_DAY_RATE_KEY)
                ?? config('parking_prices.extra_day_rate')
            );

            $diff = $this->buildDiff($currentPrices, $newPrices, $currentExtraDayRate, $newExtraDayRate);

            foreach ($newPrices as $days => $price) {
                ParkingPrice::updateOrCreate(['days' => (int) $days], ['price' => (int) $price]);
            }

            ParkingSetting::setValue(self::EXTRA_DAY_RATE_KEY, (string) $newExtraDayRate);

            if (! empty($diff['prices']) || $diff['extra_day_rate'] !== null) {
                AuditLog::record($action, $actor, $description, $diff);
            }

            return $diff;
        });
    }

    private function assertCompleteDayRange(array $newPrices): void
    {
        $expectedDays = range(self::MIN_DAYS, self::MAX_DAYS);
        $providedDays = array_map('intval', array_keys($newPrices));
        sort($providedDays);

        if ($providedDays !== $expectedDays) {
            throw new InvalidArgumentException(sprintf(
                'Prices must be provided for exactly days %d through %d.',
                self::MIN_DAYS,
                self::MAX_DAYS,
            ));
        }
    }

    private function currentDbPrices(): array
    {
        $prices = ParkingPrice::query()->pluck('price', 'days')->all();
        ksort($prices);

        return $prices;
    }

    private function buildDiff(array $current, array $new, int $currentExtraDayRate, int $newExtraDayRate): array
    {
        $priceDiff = [];

        foreach ($new as $days => $price) {
            $days = (int) $days;
            $price = (int) $price;
            $old = $current[$days] ?? null;

            if ($old !== $price) {
                $priceDiff[] = ['days' => $days, 'old' => $old, 'new' => $price];
            }
        }

        $extraDiff = $currentExtraDayRate !== $newExtraDayRate
            ? ['old' => $currentExtraDayRate, 'new' => $newExtraDayRate]
            : null;

        return [
            'prices' => $priceDiff,
            'extra_day_rate' => $extraDiff,
        ];
    }
}
