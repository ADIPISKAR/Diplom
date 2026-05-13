<select name="user_id" required>
    @foreach($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
    @endforeach
</select>
