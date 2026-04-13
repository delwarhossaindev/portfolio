<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" target="_blank" class="nav-link">View Portfolio</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light mt-1">
                        <i class="fas fa-right-from-bracket mr-1"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <span class="brand-text font-weight-light">Portfolio Admin</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                            <i class="nav-icon fas fa-gauge"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('terminal.panel') }}" class="nav-link">
                            <i class="nav-icon fas fa-terminal"></i>
                            <p>Terminal Panel</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin Dashboard</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @if(session('admin_success'))
                    <div class="alert alert-success">
                        {{ session('admin_success') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-4 col-12">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $stats['contacts'] }}</h3>
                                <p>Total Contact Messages</p>
                            </div>
                            <div class="icon"><i class="fas fa-envelope"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $stats['contentUpdatedAt'] }}</h3>
                                <p>Content Last Updated</p>
                            </div>
                            <div class="icon"><i class="fas fa-clock"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 style="font-size: 20px;">{{ $stats['lastLoginEmail'] }}</h3>
                                <p>Logged In Admin</p>
                            </div>
                            <div class="icon"><i class="fas fa-user-shield"></i></div>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Portfolio Content Manager</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.dashboard.update') }}">
                        @csrf
                        <div class="card-body">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Hero Section</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hero_greeting">Greeting</label>
                                                <input id="hero_greeting" name="hero_greeting" class="form-control" value="{{ old('hero_greeting', $content->hero_greeting) }}" required>
                                                @error('hero_greeting') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hero_name">Name</label>
                                                <input id="hero_name" name="hero_name" class="form-control" value="{{ old('hero_name', $content->hero_name) }}" required>
                                                @error('hero_name') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="hero_roles">Role (comma separated)</label>
                                                <input id="hero_roles" name="hero_roles" class="form-control" value="{{ old('hero_roles', $content->hero_roles) }}" required>
                                                @error('hero_roles') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hero_description">Hero Description</label>
                                        <textarea id="hero_description" name="hero_description" rows="4" class="form-control" required>{{ old('hero_description', $content->hero_description) }}</textarea>
                                        @error('hero_description') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">About Section</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="about_title">About Title</label>
                                        <input id="about_title" name="about_title" class="form-control" value="{{ old('about_title', $content->about_title) }}" required>
                                        @error('about_title') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="about_description">About Description</label>
                                        <textarea id="about_description" name="about_description" rows="4" class="form-control" required>{{ old('about_description', $content->about_description) }}</textarea>
                                        @error('about_description') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Contact and Social</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact_email">Email</label>
                                                <input id="contact_email" name="contact_email" class="form-control" value="{{ old('contact_email', $content->contact_email) }}" required>
                                                @error('contact_email') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact_phone">Phone</label>
                                                <input id="contact_phone" name="contact_phone" class="form-control" value="{{ old('contact_phone', $content->contact_phone) }}" required>
                                                @error('contact_phone') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact_location">Location</label>
                                                <input id="contact_location" name="contact_location" class="form-control" value="{{ old('contact_location', $content->contact_location) }}" required>
                                                @error('contact_location') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="linkedin_url">LinkedIn URL</label>
                                                <input id="linkedin_url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $content->linkedin_url) }}">
                                                @error('linkedin_url') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="github_url">GitHub URL</label>
                                                <input id="github_url" name="github_url" class="form-control" value="{{ old('github_url', $content->github_url) }}">
                                                @error('github_url') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <footer class="main-footer text-sm">
        <strong>Portfolio Admin Panel</strong>
    </footer>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
