@extends('admin.layout')

@section('title', 'Experiences')
@section('header', 'Experience')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-briefcase mr-1"></i> All Experiences <span class="badge badge-info ml-2">{{ $items->count() }}</span></h3>
            <a href="{{ route('admin.experiences.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> Add Experience
            </a>
        </div>
        <div class="card-body p-0">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:70px">#</th>
                        <th style="width:320px"><i class="fas fa-user-tie mr-1"></i> Role</th>
                        <th><i class="fas fa-building mr-1"></i> Company</th>
                        <th style="width:200px"><i class="far fa-calendar mr-1"></i> Date</th>
                        <th style="width:80px">Order</th>
                        <th style="width:110px">Status</th>
                        <th style="width:180px; text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td><span class="row-index">{{ $item->id }}</span></td>
                            <td>
                                <div class="user-cell">
                                    <span class="avatar-circle" style="background: linear-gradient(135deg,#0ea5e9,#6366f1)">
                                        <i class="{{ $item->icon ?: 'fas fa-briefcase' }}"></i>
                                    </span>
                                    <div class="user-meta">
                                        <div class="user-name">{{ $item->role }}</div>
                                        <div class="user-sub">{{ $item->location ?: '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->company }}</td>
                            <td>{{ $item->date_range }}</td>
                            <td><span class="order-chip">{{ $item->sort_order }}</span></td>
                            <td>
                                @if($item->is_active)
                                    <span class="pill pill-success"><i class="fas fa-check mr-1"></i>Active</span>
                                @else
                                    <span class="pill pill-muted"><i class="fas fa-times mr-1"></i>Hidden</span>
                                @endif
                            </td>
                            <td style="text-align:right">
                                <div class="action-group">
                                    <a href="{{ route('admin.experiences.edit', $item) }}" class="btn btn-edit">
                                        <i class="fas fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.experiences.destroy', $item) }}" onsubmit="return confirm('Delete this experience?');">
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
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-briefcase"></i>
                                No experiences yet. Click "Add Experience" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
