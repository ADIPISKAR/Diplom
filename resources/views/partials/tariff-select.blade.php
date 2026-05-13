<select name="tariff_id">
    <option value="">Без тарифа</option>
    @foreach($tariffs as $tariff)
        <option value="{{ $tariff->id }}">{{ $tariff->price_per_hour }} руб./час</option>
    @endforeach
</select>
