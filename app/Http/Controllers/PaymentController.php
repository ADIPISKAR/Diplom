<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        return view('payments.index', [
            'payments' => $request->user()
                ->payments()
                ->with(['rental.powerbank', 'paymentMethod'])
                ->latest('created_at')
                ->paginate(20),
        ]);
    }
}
