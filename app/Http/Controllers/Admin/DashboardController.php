<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use App\Services\ParkingPriceService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly ParkingPriceService $priceService)
    {
    }

    public function index(): View
    {
        $priceData = $this->priceService->getPrices();

        return view('admin.dashboard', [
            'prices' => $priceData['prices'],
            'extraDayRate' => $priceData['extra_day_rate'],
            'admins' => User::orderBy('name')->get(),
            // Sort by id, not created_at: the timestamp column only has
            // second precision, so actions in the same second (e.g. login
            // immediately followed by a save) would otherwise tie and can
            // come back in the wrong order.
            'auditLogs' => AuditLog::with('user')->latest('id')->paginate(20),
        ]);
    }
}
