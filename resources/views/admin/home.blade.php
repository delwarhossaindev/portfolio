@extends('admin.layout')

@section('title', 'Home')
@section('header', 'Home Section')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-house-user mr-1"></i> Home Section (Hero / About / Contact Info)</h3>
        </div>
        <form method="POST" action="{{ route('admin.home.update') }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="card card-outline card-info">
                    <div class="card-header"><h3 class="card-title"><i class="fas fa-star mr-1"></i> Hero</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-hand-peace mr-1"></i> Greeting</label>
                                    <input name="hero_greeting" class="form-control" value="{{ old('hero_greeting', $content->hero_greeting) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-signature mr-1"></i> Name</label>
                                    <input name="hero_name" class="form-control" value="{{ old('hero_name', $content->hero_name) }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label><i class="fas fa-user-tie mr-1"></i> Roles (comma separated)</label>
                                    <input name="hero_roles" class="form-control" value="{{ old('hero_roles', $content->hero_roles) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-align-left mr-1"></i> Hero Description</label>
                            <textarea name="hero_description" rows="4" class="form-control" required>{{ old('hero_description', $content->hero_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card card-outline card-info">
                    <div class="card-header"><h3 class="card-title"><i class="fas fa-circle-info mr-1"></i> About</h3></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label><i class="fas fa-heading mr-1"></i> About Title</label>
                            <input name="about_title" class="form-control" value="{{ old('about_title', $content->about_title) }}" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-paragraph mr-1"></i> About Description</label>
                            <textarea name="about_description" rows="4" class="form-control" required>{{ old('about_description', $content->about_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card card-outline card-info">
                    <div class="card-header"><h3 class="card-title"><i class="fas fa-address-card mr-1"></i> Contact & Social</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-envelope mr-1"></i> Email</label>
                                    <input name="contact_email" class="form-control" value="{{ old('contact_email', $content->contact_email) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-phone mr-1"></i> Phone</label>
                                    <input name="contact_phone" class="form-control" value="{{ old('contact_phone', $content->contact_phone) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-location-dot mr-1"></i> Location</label>
                                    <input name="contact_location" class="form-control" value="{{ old('contact_location', $content->contact_location) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fab fa-linkedin mr-1"></i> LinkedIn URL</label>
                                    <input name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $content->linkedin_url) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fab fa-github mr-1"></i> GitHub URL</label>
                                    <input name="github_url" class="form-control" value="{{ old('github_url', $content->github_url) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk mr-1"></i> Save Changes
                </button>
                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-info">
                    <i class="fas fa-eye mr-1"></i> Preview Portfolio
                </a>
            </div>
        </form>
    </div>
@endsection
