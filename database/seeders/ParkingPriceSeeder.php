<?php

namespace Database\Seeders;

use App\Models\ParkingPrice;
use App\Models\ParkingSetting;
use App\Services\ParkingPriceService;
use Illuminate\Database\Seeder;

class ParkingPriceSeeder extends Seeder
{
    /**
     * Seed the parking_prices / parking_settings tables from the
     * config/parking_prices.php fallback file, without overwriting any
     * prices an admin may have already set.
     */
    public function run(): void
    {
        $defaults = config('parking_prices');

        foreach ($defaults['prices'] as $days => $price) {
            ParkingPrice::firstOrCreate(['days' => $days], ['price' => $price]);
        }

        if (ParkingSetting::getValue(ParkingPriceService::EXTRA_DAY_RATE_KEY) === null) {
            ParkingSetting::setValue(ParkingPriceService::EXTRA_DAY_RATE_KEY, (string) $defaults['extra_day_rate']);
        }
    }
}
