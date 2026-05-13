<select name="rental_id" required>
    @foreach($rentals as $rental)
        <option value="{{ $rental->id }}">#{{ $rental->id }} / {{ $rental->user->name }} / {{ $rental->powerbank->code }}</option>
    @endforeach
</select>
