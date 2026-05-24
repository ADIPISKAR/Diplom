<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\View\View;

class RentalController extends Controller
{
    public function index(): View
    {
        return view('admin.rentals.index', [
            'rentals' => Rental::with(['user', 'powerbank', 'startStation', 'returnStation', 'tariff'])
                ->latest('started_at')
                ->paginate(25),
            'title' => 'Все аренды',
        ]);
    }

    public function active(): View
    {
        return view('admin.rentals.index', [
            'rentals' => Rental::with(['user', 'powerbank', 'startStation', 'returnStation', 'tariff'])
                ->where('status', 'active')
                ->latest('started_at')
                ->paginate(25),
            'title' => 'Активные аренды',
        ]);
    }
}
