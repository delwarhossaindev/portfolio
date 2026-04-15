@extends('admin.layout')

@section('title', 'Permissions')
@section('header', 'Permissions')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-key mr-1"></i> All Permissions <span class="badge badge-info ml-2">{{ $items->count() }}</span></h3>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> Add Permission
            </a>
        </div>
        <div class="card-body p-0">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:70px">#</th>
                        <th><i class="fas fa-tag mr-1"></i> Name</th>
                        <th style="width:140px"><i class="fas fa-shield mr-1"></i> Guard</th>
                        <th style="width:180px; text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td><span class="row-index">{{ $item->id }}</span></td>
                            <td>
                                <div class="user-cell">
                                    <span class="avatar-circle" style="background: linear-gradient(135deg,#0ea5e9,#06b6d4)">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <div class="user-meta">
                                        <div class="user-name">{{ $item->name }}</div>
                                        <div class="user-sub">permission identifier</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="pill pill-muted">{{ $item->guard_name }}</span></td>
                            <td style="text-align:right">
                                <div class="action-group">
                                    <a href="{{ route('admin.permissions.edit', $item) }}" class="btn btn-edit">
                                        <i class="fas fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.permissions.destroy', $item) }}" onsubmit="return confirm('Delete this permission?');">
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
                            <td colspan="4" class="empty-state">
                                <i class="fas fa-key"></i>
                                No permissions yet. Click "Add Permission" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
