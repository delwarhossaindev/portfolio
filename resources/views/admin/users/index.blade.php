@extends('admin.layout')

@section('title', 'Users')
@section('header', 'Users')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-users mr-1"></i> All Users <span class="badge badge-info ml-2">{{ $items->count() }}</span></h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> Add User
            </a>
        </div>
        <div class="card-body p-0">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:70px">#</th>
                        <th style="width:280px"><i class="fas fa-user mr-1"></i> User</th>
                        <th><i class="fas fa-user-shield mr-1"></i> Roles</th>
                        <th style="width:180px; text-align:right">Actions</th>
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
                                        <div class="user-sub"><i class="fas fa-at mr-1"></i>{{ $item->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @forelse($item->roles as $role)
                                    <span class="pill pill-role"><i class="fas fa-shield-halved mr-1"></i>{{ $role->name }}</span>
                                @empty
                                    <span class="pill pill-muted">no role</span>
                                @endforelse
                            </td>
                            <td style="text-align:right">
                                <div class="action-group">
                                    <a href="{{ route('admin.users.edit', $item) }}" class="btn btn-edit">
                                        <i class="fas fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $item) }}" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" {{ auth()->id() === $item->id ? 'disabled' : '' }}>
                                            <i class="fas fa-trash-can mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                <i class="fas fa-users"></i>
                                No users yet. Click "Add User" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
