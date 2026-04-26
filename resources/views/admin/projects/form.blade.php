@extends('admin.layout')

@section('title', $item->exists ? 'Edit Project' : 'Add Project')
@section('header', $item->exists ? 'Edit Project' : 'Add Project')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas {{ $item->exists ? 'fa-pen-to-square' : 'fa-plus-circle' }} mr-1"></i> {{ $item->exists ? 'Edit Project' : 'New Project' }}</h3>
        </div>
        <form method="POST" action="{{ $item->exists ? route('admin.projects.update', $item) : route('admin.projects.store') }}" enctype="multipart/form-data">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="card-body">

                {{-- Basic Info --}}
                <h5 class="mb-3 text-primary"><i class="fas fa-info-circle mr-1"></i> Basic Info</h5>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label><i class="fas fa-heading mr-1"></i> Title</label>
                            <input name="title" class="form-control" value="{{ old('title', $item->title) }}" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label><i class="fas fa-link mr-1"></i> Slug <small class="text-muted">(auto from title if empty)</small></label>
                            <input name="slug" class="form-control" value="{{ old('slug', $item->slug) }}" placeholder="my-project-name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-tag mr-1"></i> Company / Badge</label>
                            <input name="company_badge" class="form-control" value="{{ old('company_badge', $item->company_badge) }}" placeholder="e.g. ACI Limited">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-user-tie mr-1"></i> My Role</label>
                            <input name="role" class="form-control" value="{{ old('role', $item->role) }}" placeholder="e.g. Lead Developer">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-clock mr-1"></i> Duration</label>
                            <input name="duration" class="form-control" value="{{ old('duration', $item->duration) }}" placeholder="e.g. 6 months">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-building mr-1"></i> Client</label>
                            <input name="client" class="form-control" value="{{ old('client', $item->client) }}" placeholder="e.g. ACI Group">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left mr-1"></i> Short Description <small class="text-muted">(shown on cards, max 500 chars)</small></label>
                            <textarea name="description" rows="3" maxlength="500" class="form-control">{{ old('description', $item->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-file-alt mr-1"></i> Long Description <small class="text-muted">(shown on detail page)</small></label>
                            <textarea name="long_description" rows="6" class="form-control">{{ old('long_description', $item->long_description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-list-check mr-1"></i> Key Features <small class="text-muted">(one per line)</small></label>
                            <textarea name="key_features" rows="5" class="form-control" placeholder="User authentication&#10;Real-time notifications&#10;Payment integration">{{ old('key_features', is_array($item->key_features) ? implode("\n", $item->key_features) : '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Links & Tech --}}
                <hr>
                <h5 class="mb-3 text-primary"><i class="fas fa-link mr-1"></i> Links & Tech</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-external-link-alt mr-1"></i> Live Demo URL</label>
                            <input name="live_url" type="url" class="form-control" value="{{ old('live_url', $item->live_url) }}" placeholder="https://example.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fab fa-github mr-1"></i> GitHub URL</label>
                            <input name="github_url" type="url" class="form-control" value="{{ old('github_url', $item->github_url) }}" placeholder="https://github.com/user/repo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-code mr-1"></i> Technologies <small class="text-muted">(comma separated)</small></label>
                            <input name="technologies" class="form-control" value="{{ old('technologies', $item->technologies) }}" placeholder="Laravel, Vue.js, MySQL">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><i class="fas fa-icons mr-1"></i> Icon (FA class)</label>
                            <input name="icon" class="form-control" value="{{ old('icon', $item->icon) }}" placeholder="fas fa-folder-open">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label><i class="fas fa-sort mr-1"></i> Order</label>
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

                {{-- Cover Image --}}
                <hr>
                <h5 class="mb-3 text-primary"><i class="fas fa-image mr-1"></i> Cover Image</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-upload mr-1"></i> Upload Cover</label>
                            <input type="file" name="cover_image" accept="image/*" class="form-control-file">
                            <small class="form-text text-muted">JPG, PNG, WEBP, GIF (max 4MB). Recommended size: 1200x675.</small>
                        </div>
                        @if($item->cover_image)
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remove_cover_image" name="remove_cover_image" value="1">
                                    <label class="custom-control-label text-danger" for="remove_cover_image">Remove current cover</label>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($item->cover_image)
                            <div class="form-group">
                                <label>Current Cover</label>
                                <div>
                                    <img src="{{ asset('storage/' . $item->cover_image) }}" style="max-width: 100%; max-height: 200px; border-radius: 6px; border: 1px solid #ddd;">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Screenshots --}}
                <hr>
                <h5 class="mb-3 text-primary"><i class="fas fa-images mr-1"></i> Screenshots</h5>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-upload mr-1"></i> Add Screenshots <small class="text-muted">(can select multiple)</small></label>
                            <input type="file" name="images[]" accept="image/*" multiple class="form-control-file">
                            <small class="form-text text-muted">Each image max 4MB. Will be added to existing.</small>
                        </div>
                    </div>
                    @if(! empty($item->imageUrls()))
                        <div class="col-12">
                            <label>Existing Screenshots</label>
                            <div class="row">
                                @foreach($item->imageUrls() as $idx => $url)
                                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                                        <div style="position: relative; border-radius: 6px; overflow: hidden; border: 1px solid #ddd;">
                                            <img src="{{ $url }}" style="width: 100%; height: 120px; object-fit: cover; display: block;">
                                            <div class="custom-control custom-checkbox" style="position: absolute; top: 6px; right: 6px; background: rgba(255,255,255,0.95); padding: 4px 8px; border-radius: 4px;">
                                                <input type="checkbox" class="custom-control-input" id="remove_img_{{ $idx }}" name="remove_image_index[]" value="{{ $idx }}">
                                                <label class="custom-control-label text-danger" for="remove_img_{{ $idx }}" style="font-size: 0.75rem;">Remove</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk mr-1"></i> Save
                </button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
                @if($item->exists && $item->slug)
                    <a href="{{ route('projects.show', $item->slug) }}" target="_blank" class="btn btn-info float-right">
                        <i class="fas fa-eye mr-1"></i> View on site
                    </a>
                @endif
            </div>
        </form>
    </div>
@endsection
