<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnModel;
use Illuminate\View\View;

class ReturnController extends Controller
{
    public function index(): View
    {
        return view('admin.returns.index', [
            'returns' => ReturnModel::with(['rental', 'user', 'powerbank', 'station', 'slot'])
                ->latest('returned_at')
                ->paginate(25),
        ]);
    }
}
