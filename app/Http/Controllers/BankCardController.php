<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankCardRequest;
use App\Models\ActivityLog;
use App\Models\BankCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BankCardController extends Controller
{
    public function index(Request $request): View
    {
        return view('bank-cards.index', [
            'cards' => $request->user()->bankCards()->latest('created_at')->get(),
        ]);
    }

    public function store(StoreBankCardRequest $request): RedirectResponse
    {
        $number = preg_replace('/\D+/', '', $request->validated('card_number'));
        $user = $request->user();

        DB::transaction(function () use ($number, $request, $user): void {
            $makeDefault = $request->boolean('is_default') || ! $user->bankCards()->exists();

            if ($makeDefault) {
                $user->bankCards()->update(['is_default' => false]);
            }

            $user->bankCards()->create([
                'card_last_four' => substr($number, -4),
                'payment_token' => hash('sha256', Str::random(32).$user->id.now()->timestamp),
                'is_default' => $makeDefault,
            ]);
        });

        ActivityLog::record($user->id, 'bank_card_added', 'Добавлена банковская карта без хранения полного номера');

        return back()->with('success', 'Карта привязана. Полный номер не сохранён.');
    }

    public function makeDefault(Request $request, BankCard $bankCard): RedirectResponse
    {
        abort_unless($bankCard->user_id === $request->user()->id, 403);

        $request->user()->bankCards()->update(['is_default' => false]);
        $bankCard->update(['is_default' => true]);

        return back()->with('success', 'Карта выбрана по умолчанию.');
    }

    public function destroy(Request $request, BankCard $bankCard): RedirectResponse
    {
        abort_unless($bankCard->user_id === $request->user()->id, 403);

        $bankCard->delete();

        return back()->with('success', 'Карта удалена.');
    }
}
