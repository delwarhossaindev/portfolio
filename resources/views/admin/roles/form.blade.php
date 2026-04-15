@extends('admin.layout')

@section('title', $item->exists ? 'Edit Role' : 'Add Role')
@section('header', $item->exists ? 'Edit Role' : 'Add Role')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas {{ $item->exists ? 'fa-pen-to-square' : 'fa-plus-circle' }} mr-1"></i> {{ $item->exists ? 'Edit Role' : 'New Role' }}</h3>
        </div>
        <form method="POST" action="{{ $item->exists ? route('admin.roles.update', $item) : route('admin.roles.store') }}">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-tag mr-1"></i> Role Name</label>
                            <input name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-key mr-1"></i> Permissions</label>
                            <div>
                                @php $assigned = old('permissions', $item->exists ? $item->permissions->pluck('name')->all() : []); @endphp
                                @forelse($permissions as $perm)
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="perm_{{ $perm->id }}" name="permissions[]" value="{{ $perm->name }}" {{ in_array($perm->name, $assigned) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="perm_{{ $perm->id }}">{{ $perm->name }}</label>
                                    </div>
                                @empty
                                    <span class="text-muted">No permissions defined yet.</span>
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
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
