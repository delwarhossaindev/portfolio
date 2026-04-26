@extends('admin.layout')

@section('title', $item->exists ? 'Edit Article' : 'New Article')
@section('header', $item->exists ? 'Edit Article' : 'New Article')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas {{ $item->exists ? 'fa-pen-to-square' : 'fa-plus-circle' }} mr-1"></i> {{ $item->exists ? 'Edit Article' : 'New Article' }}</h3>
        </div>
        <form method="POST" action="{{ $item->exists ? route('admin.articles.update', $item) : route('admin.articles.store') }}" enctype="multipart/form-data">
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
                            <label><i class="fas fa-link mr-1"></i> Slug <small class="text-muted">(auto if empty)</small></label>
                            <input name="slug" class="form-control" value="{{ old('slug', $item->slug) }}" placeholder="auto-generated">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left mr-1"></i> Excerpt <small class="text-muted">(short summary, max 500 chars)</small></label>
                            <textarea name="excerpt" rows="2" maxlength="500" class="form-control">{{ old('excerpt', $item->excerpt) }}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fab fa-markdown mr-1"></i> Content <small class="text-muted">(supports Markdown)</small></label>
                            <textarea name="content" rows="20" class="form-control" style="font-family: monospace; font-size: 0.9rem;" required>{{ old('content', $item->content) }}</textarea>
                            <small class="form-text text-muted">
                                Use <code># Heading</code>, <code>**bold**</code>, <code>*italic*</code>, <code>[link](url)</code>, <code>![alt](image)</code>, <code>```code```</code>, lists, etc.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-tags mr-1"></i> Tags <small class="text-muted">(comma separated)</small></label>
                            <input name="tags" class="form-control" value="{{ old('tags', $item->tags) }}" placeholder="Laravel, Vue.js, Tutorial">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="far fa-calendar mr-1"></i> Publish Date</label>
                            <input type="datetime-local" name="published_at" class="form-control"
                                value="{{ old('published_at', $item->published_at?->format('Y-m-d\TH:i')) }}">
                            <small class="form-text text-muted">Leave empty to set automatically when publishing.</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="d-block"><i class="fas fa-globe mr-1"></i> Published</label>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" {{ old('is_published', $item->is_published) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_published"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="mb-3 text-primary"><i class="fas fa-image mr-1"></i> Cover Image</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-upload mr-1"></i> Upload</label>
                            <input type="file" name="cover_image" accept="image/*" class="form-control-file">
                            <small class="form-text text-muted">JPG, PNG, WEBP (max 4MB). Recommended 1200x675.</small>
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
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk mr-1"></i> Save
                </button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel
                </a>
                @if($item->exists && $item->slug && Route::has('blog.show'))
                    <a href="{{ route('blog.show', $item->slug) }}" target="_blank" class="btn btn-info float-right">
                        <i class="fas fa-eye mr-1"></i> View on site
                    </a>
                @endif
            </div>
        </form>
    </div>
@endsection
