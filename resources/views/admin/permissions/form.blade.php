@extends('admin.layout')

@section('title', $item->exists ? 'Edit Permission' : 'Add Permission')
@section('header', $item->exists ? 'Edit Permission' : 'Add Permission')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas {{ $item->exists ? 'fa-pen-to-square' : 'fa-plus-circle' }} mr-1"></i> {{ $item->exists ? 'Edit Permission' : 'New Permission' }}</h3>
        </div>
        <form method="POST" action="{{ $item->exists ? route('admin.permissions.update', $item) : route('admin.permissions.store') }}">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-tag mr-1"></i> Permission Name</label>
                            <input name="name" class="form-control" value="{{ old('name', $item->name) }}" placeholder="e.g. manage-projects" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk mr-1"></i> Save
                </button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
