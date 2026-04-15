@extends('admin.layout')

@section('title', $item->exists ? 'Edit Project' : 'Add Project')
@section('header', $item->exists ? 'Edit Project' : 'Add Project')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas {{ $item->exists ? 'fa-pen-to-square' : 'fa-plus-circle' }} mr-1"></i> {{ $item->exists ? 'Edit Project' : 'New Project' }}</h3>
        </div>
        <form method="POST" action="{{ $item->exists ? route('admin.projects.update', $item) : route('admin.projects.store') }}">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label><i class="fas fa-heading mr-1"></i> Title</label>
                            <input name="title" class="form-control" value="{{ old('title', $item->title) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-tag mr-1"></i> Company Badge</label>
                            <input name="company_badge" class="form-control" value="{{ old('company_badge', $item->company_badge) }}" placeholder="e.g. ACI Limited">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left mr-1"></i> Description</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $item->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label><i class="fas fa-code mr-1"></i> Technologies (comma separated)</label>
                            <input name="technologies" class="form-control" value="{{ old('technologies', $item->technologies) }}" placeholder="Laravel, Vue.js, MySQL">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><i class="fas fa-icons mr-1"></i> Icon (FA class)</label>
                            <input name="icon" class="form-control" value="{{ old('icon', $item->icon) }}" placeholder="fas fa-folder-open">
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
                            <label class="d-block"><i class="fas fa-star mr-1"></i> Featured</label>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_featured"></label>
                            </div>
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
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
