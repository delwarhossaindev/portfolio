@extends('admin.layout')

@section('title', $item->exists ? 'Edit Experience' : 'Add Experience')
@section('header', $item->exists ? 'Edit Experience' : 'Add Experience')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas {{ $item->exists ? 'fa-pen-to-square' : 'fa-plus-circle' }} mr-1"></i> {{ $item->exists ? 'Edit Experience' : 'New Experience' }}</h3>
        </div>
        <form method="POST" action="{{ $item->exists ? route('admin.experiences.update', $item) : route('admin.experiences.store') }}">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user-tie mr-1"></i> Role</label>
                            <input name="role" class="form-control" value="{{ old('role', $item->role) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-building mr-1"></i> Company</label>
                            <input name="company" class="form-control" value="{{ old('company', $item->company) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-location-dot mr-1"></i> Location</label>
                            <input name="location" class="form-control" value="{{ old('location', $item->location) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="far fa-calendar mr-1"></i> Date Range</label>
                            <input name="date_range" class="form-control" value="{{ old('date_range', $item->date_range) }}" placeholder="e.g. March 2024 - Present (1.7 yrs)">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left mr-1"></i> Description</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $item->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-code mr-1"></i> Technologies (comma separated)</label>
                            <input name="technologies" class="form-control" value="{{ old('technologies', $item->technologies) }}" placeholder="Laravel, Vue.js, REST API">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><i class="fas fa-icons mr-1"></i> Icon (FA class)</label>
                            <input name="icon" class="form-control" value="{{ old('icon', $item->icon) }}" placeholder="fas fa-briefcase">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><i class="fas fa-sort mr-1"></i> Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}" min="0">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="d-block"><i class="fas fa-toggle-on mr-1"></i> Active</label>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk mr-1"></i> Save
                </button>
                <a href="{{ route('admin.experiences.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
