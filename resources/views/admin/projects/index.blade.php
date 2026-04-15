@extends('admin.layout')

@section('title', 'Projects')
@section('header', 'Projects')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-diagram-project mr-1"></i> All Projects <span class="badge badge-info ml-2">{{ $items->count() }}</span></h3>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> Add Project
            </a>
        </div>
        <div class="card-body p-0">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:70px">#</th>
                        <th style="width:320px"><i class="fas fa-heading mr-1"></i> Title</th>
                        <th><i class="fas fa-tag mr-1"></i> Badge</th>
                        <th style="width:120px">Featured</th>
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
                                    <span class="avatar-circle" style="background: linear-gradient(135deg,#f59e0b,#ef4444)">
                                        <i class="{{ $item->icon ?: 'fas fa-folder-open' }}"></i>
                                    </span>
                                    <div class="user-meta">
                                        <div class="user-name">{{ $item->title }}</div>
                                        <div class="user-sub">project entry</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->company_badge)
                                    <span class="pill pill-role">{{ $item->company_badge }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($item->is_featured)
                                    <span class="pill pill-warning"><i class="fas fa-star mr-1"></i>Featured</span>
                                @else
                                    <span class="pill pill-muted">No</span>
                                @endif
                            </td>
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
                                    <a href="{{ route('admin.projects.edit', $item) }}" class="btn btn-edit">
                                        <i class="fas fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.projects.destroy', $item) }}" onsubmit="return confirm('Delete this project?');">
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
                                <i class="fas fa-diagram-project"></i>
                                No projects yet. Click "Add Project" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
