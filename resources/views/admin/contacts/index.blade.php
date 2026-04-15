@extends('admin.layout')

@section('title', 'Contact Messages')
@section('header', 'Contact Messages')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title mb-0"><i class="fas fa-envelope-open-text mr-1"></i> All Messages <span class="badge badge-info ml-2">{{ $items->total() }}</span></h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:60px">#</th>
                        <th><i class="fas fa-user mr-1"></i> Name</th>
                        <th><i class="fas fa-at mr-1"></i> Email</th>
                        <th><i class="fas fa-tag mr-1"></i> Subject</th>
                        <th><i class="far fa-clock mr-1"></i> Received</th>
                        <th style="width:170px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td><span class="badge badge-secondary">{{ $item->id }}</span></td>
                            <td><i class="fas fa-circle-user text-info mr-1"></i> {{ $item->name }}</td>
                            <td><a href="mailto:{{ $item->email }}" class="text-info">{{ $item->email }}</a></td>
                            <td>{{ \Illuminate\Support\Str::limit($item->subject, 40) }}</td>
                            <td><i class="far fa-clock mr-1"></i> {{ $item->created_at?->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('admin.contacts.show', $item) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <form method="POST" action="{{ route('admin.contacts.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-can"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity:0.4"></i>
                                No messages yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages())
            <div class="card-footer">
                {{ $items->links() }}
            </div>
        @endif
    </div>
@endsection
