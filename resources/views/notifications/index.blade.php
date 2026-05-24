@extends('layouts.app', ['title' => 'Уведомления'])

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 mb-4">
    <h1 class="h2 mb-0">Уведомления</h1>
    <form method="post" action="{{ route('notifications.read') }}">
        @csrf
        <button class="btn btn-outline-primary" type="submit">Отметить прочитанными</button>
    </form>
</div>

<div class="form-section">
    @forelse($notifications as $notification)
        <div class="py-3 border-bottom">
            <div class="d-flex justify-content-between gap-2">
                <div class="fw-semibold">{{ $notification->title }}</div>
                <span class="badge {{ $notification->is_read ? 'text-bg-light' : 'text-bg-primary' }}">{{ $notification->is_read ? 'прочитано' : 'новое' }}</span>
            </div>
            <div class="text-secondary">{{ $notification->message }}</div>
            <div class="small text-secondary">{{ $notification->created_at?->format('d.m.Y H:i') }}</div>
        </div>
    @empty
        <div class="text-secondary">Уведомлений пока нет.</div>
    @endforelse
    {{ $notifications->links() }}
</div>
@endsection
