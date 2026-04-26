@extends('admin.layout')

@section('title', 'Home')
@section('header', 'Home Section')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-house-user mr-1"></i> Home Section (Hero / About / Contact Info)</h3>
        </div>
        <form method="POST" action="{{ route('admin.home.update') }}" enctype="multipart/form-data">
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

                        <div class="form-group">
                            <label><i class="fas fa-image mr-1"></i> Profile Image</label>
                            @php
                                $currentImage = $content->profile_image
                                    ? asset('storage/' . $content->profile_image)
                                    : asset('images/profile.jpg');
                            @endphp
                            <div class="d-flex align-items-center" style="gap:18px; flex-wrap:wrap">
                                <div style="width:110px; height:110px; border-radius:50%; overflow:hidden; border:3px solid rgba(99,102,241,0.45); box-shadow:0 6px 18px rgba(79,70,229,0.35); background:#1f2937">
                                    <img id="profile-image-preview" src="{{ $currentImage }}" alt="Profile preview" style="width:100%; height:100%; object-fit:cover">
                                </div>
                                <div style="flex:1; min-width:240px">
                                    <input type="file" name="profile_image" id="profile_image" accept="image/*" class="form-control-file" onchange="(function(inp){var f=inp.files&&inp.files[0]; if(!f) return; var r=new FileReader(); r.onload=function(e){document.getElementById('profile-image-preview').src=e.target.result;}; r.readAsDataURL(f);})(this)">
                                    <small class="form-text text-muted">JPG, PNG, WEBP or GIF. Max 4 MB. Leave empty to keep the current image.</small>
                                    @if($content->profile_image)
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="remove_profile_image" name="remove_profile_image" value="1">
                                            <label class="custom-control-label text-danger" for="remove_profile_image">
                                                <i class="fas fa-trash-can mr-1"></i>Remove uploaded image (revert to default)
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
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

                {{-- SEO Section --}}
                <div class="card card-outline card-success">
                    <div class="card-header"><h3 class="card-title"><i class="fas fa-magnifying-glass-chart mr-1"></i> SEO Settings</h3></div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">
                            <i class="fas fa-info-circle"></i>
                            These fields control how your portfolio appears in search engines and on social media (Facebook, LinkedIn, Twitter shares).
                            Leave blank to use sensible defaults.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-heading mr-1"></i> Meta Title <small class="text-muted">(50-60 chars)</small></label>
                                    <input name="meta_title" class="form-control" maxlength="255"
                                           value="{{ old('meta_title', $content->meta_title) }}"
                                           placeholder="e.g. Delwar Hossain - Full Stack Laravel Developer">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-globe mr-1"></i> Site URL</label>
                                    <input type="url" name="site_url" class="form-control"
                                           value="{{ old('site_url', $content->site_url) }}"
                                           placeholder="https://yourdomain.com">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label><i class="fas fa-align-left mr-1"></i> Meta Description <small class="text-muted">(150-160 chars)</small></label>
                                    <textarea name="meta_description" rows="2" maxlength="500" class="form-control"
                                              placeholder="Short description that shows in Google results">{{ old('meta_description', $content->meta_description) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><i class="fas fa-tags mr-1"></i> Meta Keywords <small class="text-muted">(comma separated)</small></label>
                                    <input name="meta_keywords" class="form-control"
                                           value="{{ old('meta_keywords', $content->meta_keywords) }}"
                                           placeholder="Laravel, Vue.js, PHP Developer, Bangladesh">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fab fa-twitter mr-1"></i> Twitter Handle</label>
                                    <input name="twitter_handle" class="form-control"
                                           value="{{ old('twitter_handle', $content->twitter_handle) }}"
                                           placeholder="@yourhandle">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label><i class="fas fa-share-nodes mr-1"></i> Social Share Image (OG image)</label>
                                    <small class="form-text text-muted mb-2">
                                        This shows when your link is shared on Facebook, LinkedIn, Twitter, WhatsApp, etc.
                                        Recommended: 1200×630 pixels. JPG/PNG/WEBP, max 4 MB.
                                        If empty, your profile image will be used.
                                    </small>
                                    <div class="d-flex align-items-center" style="gap:18px; flex-wrap:wrap">
                                        <div style="width:200px; height:105px; border-radius:8px; overflow:hidden; border:1px solid rgba(99,102,241,0.45); background:#1f2937">
                                            @if($content->og_image)
                                                <img src="{{ asset('storage/' . $content->og_image) }}" alt="OG image" style="width:100%; height:100%; object-fit:cover">
                                            @else
                                                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#666; font-size:0.8rem">
                                                    <i class="fas fa-image fa-2x"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div style="flex:1; min-width:240px">
                                            <input type="file" name="og_image" accept="image/*" class="form-control-file">
                                            @if($content->og_image)
                                                <div class="custom-control custom-checkbox mt-2">
                                                    <input type="checkbox" class="custom-control-input" id="remove_og_image" name="remove_og_image" value="1">
                                                    <label class="custom-control-label text-danger" for="remove_og_image">
                                                        <i class="fas fa-trash-can mr-1"></i> Remove OG image
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
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
