<select name="station_id" required>
    @foreach($stations as $station)
        <option value="{{ $station->id }}" @selected((string) $value === (string) $station->id)>{{ $station->location }}</option>
    @endforeach
</select>
