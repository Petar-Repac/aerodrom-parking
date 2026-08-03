<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ParkingPriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class PriceController extends Controller
{
    public function __construct(private readonly ParkingPriceService $priceService)
    {
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'prices' => ['required', 'array'],
            'prices.*' => ['required', 'integer', 'min:0'],
            'extra_day_rate' => ['required', 'integer', 'min:0'],
        ]);

        try {
            $diff = $this->priceService->updatePrices(
                $validated['prices'],
                $validated['extra_day_rate'],
                $request->user(),
            );
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'diff' => $diff,
        ]);
    }

    public function reset(Request $request): JsonResponse
    {
        $diff = $this->priceService->resetToDefault($request->user());

        return response()->json([
            'status' => 'success',
            'diff' => $diff,
        ]);
    }
}
