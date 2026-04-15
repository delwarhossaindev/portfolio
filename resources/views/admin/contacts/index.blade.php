@extends('admin.layout')

@section('title', 'Contact Messages')
@section('header', 'Contact Messages')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title mb-0"><i class="fas fa-envelope-open-text mr-1"></i> All Messages <span class="badge badge-info ml-2">{{ $items->total() }}</span></h3>
        </div>
        <div class="card-body p-0">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:70px">#</th>
                        <th style="width:280px"><i class="fas fa-user mr-1"></i> Sender</th>
                        <th><i class="fas fa-tag mr-1"></i> Subject</th>
                        <th style="width:180px"><i class="far fa-clock mr-1"></i> Received</th>
                        <th style="width:230px; text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td><span class="row-index">{{ $item->id }}</span></td>
                            <td>
                                <div class="user-cell">
                                    <span class="avatar-circle">{{ strtoupper(mb_substr($item->name, 0, 1)) }}</span>
                                    <div class="user-meta">
                                        <div class="user-name">{{ $item->name }}</div>
                                        <div class="user-sub"><a href="mailto:{{ $item->email }}" style="color:inherit"><i class="fas fa-at mr-1"></i>{{ $item->email }}</a></div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($item->subject, 50) }}</td>
                            <td><span class="pill pill-muted"><i class="far fa-clock mr-1"></i>{{ $item->created_at?->diffForHumans() }}</span></td>
                            <td style="text-align:right">
                                <div class="action-group">
                                    <a href="{{ route('admin.contacts.show', $item) }}" class="btn btn-view">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    <form method="POST" action="{{ route('admin.contacts.destroy', $item) }}" onsubmit="return confirm('Delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete">
                                            <i class="fas fa-trash-can mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="fas fa-inbox"></i>
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
