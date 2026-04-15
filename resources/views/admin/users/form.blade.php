@extends('admin.layout')

@section('title', $item->exists ? 'Edit User' : 'Add User')
@section('header', $item->exists ? 'Edit User' : 'Add User')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas {{ $item->exists ? 'fa-pen-to-square' : 'fa-user-plus' }} mr-1"></i> {{ $item->exists ? 'Edit User' : 'New User' }}</h3>
        </div>
        <form method="POST" action="{{ $item->exists ? route('admin.users.update', $item) : route('admin.users.store') }}">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user mr-1"></i> Name</label>
                            <input name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-at mr-1"></i> Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $item->email) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-key mr-1"></i> Password {{ $item->exists ? '(leave blank to keep current)' : '' }}</label>
                            <input type="password" name="password" class="form-control" {{ $item->exists ? '' : 'required' }} minlength="6">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-user-shield mr-1"></i> Roles</label>
                            <div>
                                @php $assigned = old('roles', $item->exists ? $item->roles->pluck('name')->all() : []); @endphp
                                @forelse($roles as $role)
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}" {{ in_array($role->name, $assigned) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @empty
                                    <span class="text-muted">No roles defined yet.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk mr-1"></i> Save
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
