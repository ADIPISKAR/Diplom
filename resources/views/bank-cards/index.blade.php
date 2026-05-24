@extends('layouts.app', ['title' => 'Банковские карты'])

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="form-section">
            <h1 class="h3 mb-3">Добавить карту</h1>
            <form method="post" action="{{ route('bank-cards.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="card_number">Номер карты</label>
                    <input class="form-control" id="card_number" name="card_number" inputmode="numeric" autocomplete="off" value="{{ old('card_number') }}" required>
                    <div class="form-text">Сохраняются только последние четыре цифры и демо-токен оплаты.</div>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1" @checked(old('is_default'))>
                    <label class="form-check-label" for="is_default">Карта по умолчанию</label>
                </div>
                <button class="btn btn-primary w-100" type="submit">Привязать карту</button>
            </form>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="form-section">
            <h2 class="h4 mb-3">Ваши карты</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Карта</th><th>Статус</th><th></th></tr></thead>
                    <tbody>
                    @forelse($cards as $card)
                        <tr>
                            <td>•••• {{ $card->card_last_four }}</td>
                            <td>{{ $card->is_default ? 'по умолчанию' : 'доступна' }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    @unless($card->is_default)
                                        <form method="post" action="{{ route('bank-cards.default', $card) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-primary" type="submit">Выбрать</button>
                                        </form>
                                    @endunless
                                    <form method="post" action="{{ route('bank-cards.destroy', $card) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-secondary">Карты пока не добавлены.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
