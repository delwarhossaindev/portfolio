<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('partials.seo-meta', [
        'seoTitle' => $project->title . ' - ' . $content->hero_name,
        'seoDescription' => $project->description ?: $project->long_description,
        'seoKeywords' => implode(', ', array_merge($project->techList(), [$project->company_badge ?: '', 'portfolio project'])),
        'seoImage' => $project->coverImageUrl() ?: ($content->profile_image ? asset('storage/' . $content->profile_image) : asset('images/profile.jpg')),
        'seoType' => 'article',
    ])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">

    {{-- JSON-LD: BreadcrumbList --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": @json(url('/'))
            },
            {
                "@@type": "ListItem",
                "position": 2,
                "name": "Projects",
                "item": @json(url('/') . '#projects')
            },
            {
                "@@type": "ListItem",
                "position": 3,
                "name": @json($project->title),
                "item": @json(route('projects.show', $project->slug))
            }
        ]
    }
    </script>

    {{-- JSON-LD: CreativeWork (Project) --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "CreativeWork",
        "name": @json($project->title),
        "description": @json($project->description ?: \Illuminate\Support\Str::limit(strip_tags($project->long_description ?? ''), 200)),
        "url": @json(route('projects.show', $project->slug)),
        @if($project->coverImageUrl())
        "image": @json($project->coverImageUrl()),
        @endif
        "author": {
            "@@type": "Person",
            "name": @json($content->hero_name),
            "url": @json(url('/'))
        },
        "creator": {
            "@@type": "Person",
            "name": @json($content->hero_name)
        },
        "keywords": @json(implode(', ', $project->techList())),
        "dateCreated": @json($project->created_at?->toIso8601String()),
        "dateModified": @json($project->updated_at?->toIso8601String())
    }
    </script>
</head>
<body>
    {{-- Navigation --}}
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ url('/') }}" class="nav-logo">
                <span class="logo-text">DELWAR</span>
                <div class="logo-eyes">
                    <div class="eye"><div class="eyeball"></div></div>
                    <div class="eye"><div class="eyeball"></div></div>
                </div>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="{{ url('/') }}#home">Home</a></li>
                <li><a href="{{ url('/') }}#experience">Experience</a></li>
                <li><a href="{{ url('/') }}#projects">Projects</a></li>
                <li><a href="{{ url('/') }}#contact">Contact</a></li>
                @auth
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge"></i> Dashboard</a></li>
                @else
                    <li><a href="{{ route('admin.login') }}" class="nav-signin"><i class="fas fa-right-to-bracket"></i> Sign In</a></li>
                @endauth
            </ul>
            <div class="nav-right">
                <div class="theme-switch" id="themeSwitch" title="Toggle Light/Dark Mode">
                    <i class="fas fa-sun"></i>
                    <div class="switch-track"><div class="switch-thumb"></div></div>
                    <i class="fas fa-moon"></i>
                </div>
                <button class="nav-toggle" id="navToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    {{-- Project Detail Hero --}}
    <section class="project-detail-hero">
        <div class="container">
            <nav aria-label="Breadcrumb" class="breadcrumb-nav">
                <ol class="breadcrumb-list">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/') }}#projects">Projects</a></li>
                    <li aria-current="page">{{ \Illuminate\Support\Str::limit($project->title, 40) }}</li>
                </ol>
            </nav>

            <a href="{{ url('/') }}#projects" class="back-link">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to projects
            </a>

            <div class="project-detail-header">
                <div class="project-detail-badge-row">
                    @if($project->company_badge)
                        <span class="project-company-badge">{{ $project->company_badge }}</span>
                    @endif
                    @if($project->is_featured)
                        <span class="featured-badge"><i class="fas fa-star"></i> Featured</span>
                    @endif
                </div>

                <h1 class="project-detail-title">
                    <i class="{{ $project->icon ?: 'fas fa-folder-open' }}"></i>
                    {{ $project->title }}
                </h1>

                @if($project->description)
                    <p class="project-detail-tagline">{{ $project->description }}</p>
                @endif

                @if(count($project->techList()))
                    <div class="project-tech project-detail-tech">
                        @foreach($project->techList() as $tech)
                            <span>{{ $tech }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="project-detail-actions">
                    @if($project->live_url)
                        <a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="btn btn-primary">
                            <i class="fas fa-external-link-alt"></i> Live Demo
                        </a>
                    @endif
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn btn-outline">
                            <i class="fab fa-github"></i> View Code
                        </a>
                    @endif
                </div>
            </div>

            @if($project->coverImageUrl())
                <div class="project-detail-cover">
                    <img src="{{ $project->coverImageUrl() }}" alt="{{ $project->title }}" loading="eager">
                </div>
            @endif
        </div>
    </section>

    {{-- Project Detail Body --}}
    <section class="project-detail-body">
        <div class="container">
            <div class="project-detail-grid">
                <div class="project-detail-content">
                    @if($project->long_description)
                        <h2 class="section-title">Overview</h2>
                        <div class="project-detail-description">
                            {!! nl2br(e($project->long_description)) !!}
                        </div>
                    @endif

                    @if(!empty($project->key_features))
                        <h2 class="section-title">Key Features</h2>
                        <ul class="key-features-list">
                            @foreach($project->key_features as $feature)
                                @if(trim($feature))
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    @if(count($project->imageUrls()))
                        <h2 class="section-title">Screenshots</h2>
                        <div class="screenshots-grid">
                            @foreach($project->imageUrls() as $url)
                                <a href="{{ $url }}" target="_blank" class="screenshot-item">
                                    <img src="{{ $url }}" alt="Screenshot" loading="lazy">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <aside class="project-detail-sidebar">
                    <div class="info-card">
                        <h3>Project Info</h3>
                        <dl class="info-list">
                            @if($project->client)
                                <div class="info-row">
                                    <dt><i class="fas fa-building"></i> Client</dt>
                                    <dd>{{ $project->client }}</dd>
                                </div>
                            @endif
                            @if($project->role)
                                <div class="info-row">
                                    <dt><i class="fas fa-user-tie"></i> My Role</dt>
                                    <dd>{{ $project->role }}</dd>
                                </div>
                            @endif
                            @if($project->duration)
                                <div class="info-row">
                                    <dt><i class="fas fa-clock"></i> Duration</dt>
                                    <dd>{{ $project->duration }}</dd>
                                </div>
                            @endif
                            <div class="info-row">
                                <dt><i class="fas fa-eye"></i> Views</dt>
                                <dd>{{ number_format($project->view_count) }}</dd>
                            </div>
                        </dl>

                        @if($project->live_url || $project->github_url)
                            <div class="info-card-actions">
                                @if($project->live_url)
                                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="info-link">
                                        <i class="fas fa-external-link-alt"></i> Visit Live Site
                                    </a>
                                @endif
                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="info-link">
                                        <i class="fab fa-github"></i> Source Code
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- Related Projects --}}
    @if(count($related))
        <section class="related-section">
            <div class="container">
                <h2 class="section-title section-title-center">More Projects</h2>
                <div class="projects-grid">
                    @foreach($related as $rel)
                        <a href="{{ route('projects.show', $rel->slug) }}" class="project-card-link">
                            <div class="project-card {{ $rel->is_featured ? 'featured' : '' }}">
                                <div class="project-header">
                                    <i class="{{ $rel->icon ?: 'fas fa-folder-open' }} project-icon"></i>
                                    @if($rel->company_badge)
                                        <div class="project-links">
                                            <span class="project-company-badge">{{ $rel->company_badge }}</span>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="project-title">{{ $rel->title }}</h3>
                                @if($rel->description)
                                    <p class="project-description">{{ Str::limit($rel->description, 120) }}</p>
                                @endif
                                @if(count($rel->techList()))
                                    <div class="project-tech">
                                        @foreach(array_slice($rel->techList(), 0, 4) as $tech)
                                            <span>{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ $content->hero_name }}. All Rights Reserved.</p>
        </div>
    </footer>

    {{-- Back to top --}}
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="{{ asset('js/portfolio.js') }}"></script>
</body>
</html>
