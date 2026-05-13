@php
    $options = [
        'station' => ['active' => 'Активна', 'maintenance' => 'Обслуживание', 'inactive' => 'Отключена'],
        'powerbank' => ['available' => 'Доступен', 'rented' => 'В аренде', 'maintenance' => 'Обслуживание', 'lost' => 'Потерян'],
        'rental' => ['active' => 'Активна', 'completed' => 'Завершена', 'overdue' => 'Просрочена', 'cancelled' => 'Отменена'],
        'payment' => ['paid' => 'Оплачен', 'pending' => 'Ожидает', 'failed' => 'Ошибка'],
    ][$type];
@endphp
<select name="{{ $name }}" required>
    @foreach($options as $key => $label)
        <option value="{{ $key }}" @selected($value === $key)>{{ $label }}</option>
    @endforeach
</select>
