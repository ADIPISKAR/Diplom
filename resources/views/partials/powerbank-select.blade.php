<select name="powerbank_id" required>
    @foreach($powerbanks as $powerbank)
        <option value="{{ $powerbank->id }}">{{ $powerbank->code }} / {{ $powerbank->station->location }}</option>
    @endforeach
</select>
