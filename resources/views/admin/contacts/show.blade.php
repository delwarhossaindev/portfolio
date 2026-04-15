@extends('admin.layout')

@section('title', 'Message')
@section('header', 'Message Detail')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-envelope-open-text mr-1"></i> From {{ $item->name }}</h3>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>
        <div class="card-body">
            <p><i class="fas fa-user text-info mr-2"></i><strong>Name:</strong> {{ $item->name }}</p>
            <p><i class="fas fa-at text-info mr-2"></i><strong>Email:</strong> <a href="mailto:{{ $item->email }}">{{ $item->email }}</a></p>
            <p><i class="fas fa-tag text-info mr-2"></i><strong>Subject:</strong> {{ $item->subject }}</p>
            <p><i class="far fa-clock text-info mr-2"></i><strong>Received:</strong> {{ $item->created_at?->format('M d, Y H:i') }}</p>
            <hr>
            <p><i class="fas fa-comment-dots text-info mr-2"></i><strong>Message:</strong></p>
            <div class="p-3" style="background:rgba(79,70,229,0.08); border-radius:8px; border-left:3px solid #6366f1">
                {!! nl2br(e($item->message)) !!}
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="mailto:{{ $item->email }}?subject=Re: {{ $item->subject }}" class="btn btn-success">
                <i class="fas fa-reply mr-1"></i> Reply via Email
            </a>
            <form method="POST" action="{{ route('admin.contacts.destroy', $item) }}" onsubmit="return confirm('Delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-can mr-1"></i> Delete Message
                </button>
            </form>
        </div>
    </div>
@endsection
