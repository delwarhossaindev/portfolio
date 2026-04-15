@extends('admin.layout')

@section('title', 'Roles')
@section('header', 'Roles')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-user-shield mr-1"></i> All Roles <span class="badge badge-info ml-2">{{ $items->count() }}</span></h3>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> Add Role
            </a>
        </div>
        <div class="card-body p-0">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:70px">#</th>
                        <th style="width:220px"><i class="fas fa-tag mr-1"></i> Name</th>
                        <th><i class="fas fa-key mr-1"></i> Permissions</th>
                        <th style="width:180px; text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td><span class="row-index">{{ $item->id }}</span></td>
                            <td>
                                <div class="user-cell">
                                    <span class="avatar-circle" style="background: linear-gradient(135deg,#4f46e5,#9333ea)">
                                        <i class="fas fa-user-shield"></i>
                                    </span>
                                    <div class="user-meta">
                                        <div class="user-name">{{ $item->name }}</div>
                                        <div class="user-sub">{{ $item->permissions->count() }} permission{{ $item->permissions->count() === 1 ? '' : 's' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @forelse($item->permissions as $perm)
                                    <span class="pill pill-perm">{{ $perm->name }}</span>
                                @empty
                                    <span class="pill pill-muted">no permissions</span>
                                @endforelse
                            </td>
                            <td style="text-align:right">
                                <div class="action-group">
                                    <a href="{{ route('admin.roles.edit', $item) }}" class="btn btn-edit">
                                        <i class="fas fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.roles.destroy', $item) }}" onsubmit="return confirm('Delete this role?');">
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
                                <i class="fas fa-user-shield"></i>
                                No roles yet. Click "Add Role" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
