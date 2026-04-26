<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('partials.seo-meta', [
        'seoTitle' => $content->meta_title ?: $content->hero_name . ' - Full Stack Developer Portfolio',
        'seoType' => 'website',
    ])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">

    {{-- JSON-LD: Person schema --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Person",
        "name": @json($content->hero_name),
        "jobTitle": "Full Stack Developer",
        "url": @json(url('/')),
        "image": @json($content->profile_image ? asset('storage/' . $content->profile_image) : asset('images/profile.jpg')),
        "email": @json('mailto:' . $content->contact_email),
        "telephone": @json($content->contact_phone),
        "address": {
            "@@type": "PostalAddress",
            "addressLocality": @json($content->contact_location)
        },
        "sameAs": [
            @json($content->linkedin_url),
            @json($content->github_url)
        ],
        "knowsAbout": ["PHP", "Laravel", "Vue.js", "JavaScript", "MySQL", "REST API", "Full Stack Development"],
        "alumniOf": {
            "@@type": "EducationalOrganization",
            "name": "Bangladesh Army International University of Science and Technology (BAIUST)"
        },
        "description": @json($content->hero_description)
    }
    </script>

    {{-- JSON-LD: WebSite schema --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": @json($content->hero_name . ' Portfolio'),
        "url": @json(url('/')),
        "description": @json($content->hero_description)
    }
    </script>
    <style>
        #page-preloader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 50% 40%, #1a1f3a 0%, #0b0f1e 60%, #05070f 100%);
            transition: opacity 0.55s ease, visibility 0.55s ease;
        }
        #page-preloader.preloader-hidden {
            opacity: 0;
            visibility: hidden;
        }
        #page-preloader .pl-ring {
            position: relative;
            width: 96px;
            height: 96px;
        }
        #page-preloader .pl-ring::before,
        #page-preloader .pl-ring::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 3px solid transparent;
        }
        #page-preloader .pl-ring::before {
            border-top-color: #6366f1;
            border-right-color: #ec4899;
            animation: pl-spin 1.1s linear infinite;
        }
        #page-preloader .pl-ring::after {
            inset: 14px;
            border-bottom-color: #22d3ee;
            border-left-color: #a855f7;
            animation: pl-spin 1.6s linear reverse infinite;
        }
        #page-preloader .pl-core {
            position: absolute;
            inset: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            box-shadow: 0 0 22px rgba(99,102,241,0.55);
            animation: pl-pulse 1.4s ease-in-out infinite;
        }
        #page-preloader .pl-brand {
            margin-top: 28px;
            font-family: 'Fira Code', monospace;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 6px;
            background: linear-gradient(90deg, #6366f1, #ec4899, #22d3ee);
            background-size: 200% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: pl-shimmer 2.5s linear infinite;
        }
        #page-preloader .pl-label {
            margin-top: 10px;
            font-family: 'Fira Code', monospace;
            font-size: 12px;
            color: #64748b;
            letter-spacing: 2px;
        }
        #page-preloader .pl-dots::after {
            content: '';
            animation: pl-dots 1.4s steps(4, end) infinite;
        }
        @keyframes pl-spin { to { transform: rotate(360deg); } }
        @keyframes pl-pulse {
            0%, 100% { transform: scale(1); opacity: 0.95; }
            50% { transform: scale(0.82); opacity: 0.65; }
        }
        @keyframes pl-shimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }
        @keyframes pl-dots {
            0% { content: ''; }
            25% { content: '.'; }
            50% { content: '..'; }
            75% { content: '...'; }
        }
    </style>
</head>
<body>
    {{-- Skip to main content (keyboard a11y) --}}
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <div id="page-preloader" aria-hidden="true">
        <div class="pl-ring">
            <div class="pl-core"></div>
        </div>
        <div class="pl-brand">DELWAR</div>
        <div class="pl-label">loading<span class="pl-dots"></span></div>
    </div>

    {{-- Live region for status announcements (form success, etc.) --}}
    <div id="live-status" class="sr-only" role="status" aria-live="polite" aria-atomic="true"></div>

    {{-- Navigation --}}
    <nav class="navbar" id="navbar" aria-label="Main navigation">
        <div class="nav-container">
            <a href="#home" class="nav-logo" aria-label="DELWAR - Home">
                <span class="logo-text">DELWAR</span>
                <div class="logo-eyes" aria-hidden="true">
                    <div class="eye">
                        <div class="eyeball"></div>
                    </div>
                    <div class="eye">
                        <div class="eyeball"></div>
                    </div>
                </div>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="#home">Home</a></li>
                <li><a href="#experience">Experience</a></li>
                <li><a href="#projects">Projects</a></li>
                {{-- <li><a href="{{ route('blog.index') }}">Blog</a></li> --}}
                <li><a href="#contact">Contact</a></li>
                @auth
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge" aria-hidden="true"></i> Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="nav-signin-btn"><i class="fas fa-right-from-bracket" aria-hidden="true"></i> Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('admin.login') }}" class="nav-signin"><i class="fas fa-right-to-bracket" aria-hidden="true"></i> Sign In</a></li>
                @endauth
            </ul>
            <div class="nav-right">
                <button type="button"
                        class="theme-switch"
                        id="themeSwitch"
                        role="switch"
                        aria-checked="false"
                        aria-label="Toggle light and dark mode">
                    <i class="fas fa-sun" aria-hidden="true"></i>
                    <span class="switch-track" aria-hidden="true">
                        <span class="switch-thumb"></span>
                    </span>
                    <i class="fas fa-moon" aria-hidden="true"></i>
                </button>
                <button class="nav-toggle"
                        id="navToggle"
                        type="button"
                        aria-label="Open menu"
                        aria-expanded="false"
                        aria-controls="navLinks">
                    <i class="fas fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </nav>

    <main id="main-content">

    {{-- Hero Section --}}
    <section class="hero" id="home" aria-labelledby="hero-heading">
        <div class="hero-particles" id="particles" aria-hidden="true"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <p class="hero-greeting">{{ $content->hero_greeting }}</p>
                    <h1 class="hero-name" id="hero-heading">{{ $content->hero_name }}</h1>
                    <p class="hero-role">I'm a <span class="typed-text" id="typedText" data-roles="{{ $content->hero_roles }}" aria-live="polite"></span><span class="cursor" aria-hidden="true">|</span></p>
                    <p class="hero-description">{{ $content->hero_description }}</p>
                    <div class="hero-social" aria-label="Social links">
                        <a href="{{ $content->linkedin_url }}" class="social-link" aria-label="LinkedIn profile (opens in new tab)" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                        <a href="{{ $content->github_url }}" class="social-link" aria-label="GitHub profile (opens in new tab)" target="_blank" rel="noopener noreferrer"><i class="fab fa-github" aria-hidden="true"></i></a>
                        <a href="mailto:{{ $content->contact_email }}" class="social-link" aria-label="Send email"><i class="fas fa-envelope" aria-hidden="true"></i></a>
                    </div>
                    <div class="hero-actions">
                        <a href="#contact" class="btn btn-primary"><span>Hire Me</span></a>
                        <a href="{{ asset('files/CV_Delwar_Hossain.pdf') }}" class="btn btn-outline" download aria-label="Download resume PDF"><i class="fas fa-download" aria-hidden="true"></i> Resume</a>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="image-wrapper">
                        <div class="image-glow" aria-hidden="true"></div>
                        @if($content->profile_image)
                            <img src="{{ asset('storage/' . $content->profile_image) }}"
                                 alt="Portrait of {{ $content->hero_name }}"
                                 class="profile-img"
                                 fetchpriority="high"
                                 decoding="async"
                                 width="340" height="340">
                        @else
                            <picture>
                                <source srcset="{{ asset('images/profile.webp') }}" type="image/webp">
                                <img src="{{ asset('images/profile.jpg') }}"
                                     alt="Portrait of {{ $content->hero_name }}"
                                     class="profile-img"
                                     fetchpriority="high"
                                     decoding="async"
                                     width="340" height="340">
                            </picture>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator" aria-hidden="true">
            <div class="scroll-mouse"></div>
            <span>scroll</span>
        </div>
    </section>

    {{-- About Me Section --}}
    <section class="about-section" id="about" aria-labelledby="about-heading">
        <div class="container">
            <div class="about-grid fade-in-stagger">
                <div class="about-content">
                    <h2 class="section-title" id="about-heading">{{ $content->about_title }}</h2>
                    <p>{!! nl2br(e($content->about_description)) !!}</p>
                    <p>
                        I hold a <strong>Bachelor of Science in Computer Science & Engineering</strong> from
                        <strong>Bangladesh Army International University of Science and Technology (BAIUST)</strong>,
                        graduated in 2020 with 161 credits.
                    </p>
                    <p>
                        Currently working as a Software Engineer at <strong>ACI Limited</strong>, Dhaka.
                        Previously contributed to enterprise solutions at MBM Group and Ringer Soft Limited.
                        My specialization includes <strong>Laravel Framework</strong> and <strong>Vue.js</strong>.
                    </p>
                    <div class="about-stats">
                        <div class="stat-item">
                            <span class="stat-number" data-count="5.7">0</span>
                            <span class="stat-label">Years Experience</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" data-count="4">0</span>
                            <span class="stat-label">Companies Worked</span>
                        </div>
                    </div>
                </div>
                <div class="tech-stack">
                    <h2 class="section-title" id="tech-heading">Tech Stack</h2>
                    <div class="tech-grid fade-in-stagger" aria-labelledby="tech-heading">
                        {{-- Frontend --}}
                        <div class="tech-icon" title="HTML5">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" alt="HTML5" loading="lazy" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="CSS3">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" alt="CSS3" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="JavaScript">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="Vue.js">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg" alt="Vue.js" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="jQuery">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/jquery/jquery-original.svg" alt="jQuery" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="Bootstrap">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" alt="Bootstrap" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        {{-- Backend --}}
                        <div class="tech-icon" title="PHP">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="Laravel">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg" alt="Laravel" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="Java">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/java/java-original.svg" alt="Java" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        {{-- Database --}}
                        <div class="tech-icon" title="MySQL">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="MySQL" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="Oracle">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/oracle/oracle-original.svg" alt="Oracle" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        {{-- Tools --}}
                        <div class="tech-icon" title="Git">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg" alt="Git" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="GitHub">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg" alt="GitHub" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="Trello">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/trello/trello-plain.svg" alt="Trello" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                        <div class="tech-icon" title="VS Code">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vscode/vscode-original.svg" alt="VS Code" loading="lazy" decoding="async" width="36" height="36">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Work Experience Section --}}
    <section class="experience-section" id="experience" aria-labelledby="experience-heading">
        <div class="container">
            <h2 class="section-title section-title-center" id="experience-heading">Work Experience</h2>
            <p class="section-subtitle">My professional journey and career milestones</p>
            <ol class="timeline">
                @foreach($experiences as $exp)
                    <li class="timeline-item">
                        <div class="timeline-dot" aria-hidden="true">
                            <i class="{{ $exp->icon ?: 'fas fa-briefcase' }}"></i>
                        </div>
                        <div class="timeline-content">
                            <h3>{{ $exp->role }}</h3>
                            <span class="timeline-company">{{ $exp->company }}</span>
                            @if($exp->location)
                                <span class="timeline-location"><i class="fas fa-map-marker-alt" aria-hidden="true"></i> {{ $exp->location }}</span>
                            @endif
                            @if($exp->date_range)
                                <span class="timeline-date">{{ $exp->date_range }}</span>
                            @endif
                            @if($exp->description)
                                <p>{{ $exp->description }}</p>
                            @endif
                            @if(count($exp->techList()))
                                <div class="timeline-tech" aria-label="Technologies used">
                                    @foreach($exp->techList() as $tech)
                                        <span>{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Projects Section --}}
    <section class="projects-section" id="projects" aria-labelledby="projects-heading">
        <div class="container">
            <h2 class="section-title section-title-center" id="projects-heading">Projects</h2>
            <p class="section-subtitle">Things I've built that I'm proud of</p>
            <div class="projects-grid fade-in-stagger">
                @foreach($projects as $project)
                    <article class="project-card {{ $project->is_featured ? 'featured' : '' }}" aria-labelledby="project-{{ $project->id }}-title">
                        @if($project->coverImageUrl())
                            <a href="{{ route('projects.show', $project->slug) }}" class="project-cover" tabindex="-1" aria-hidden="true">
                                <img src="{{ $project->coverImageUrl() }}" alt="" loading="lazy">
                            </a>
                        @endif
                        <div class="project-card-body">
                            <div class="project-header">
                                <i class="{{ $project->icon ?: 'fas fa-folder-open' }} project-icon" aria-hidden="true"></i>
                                <div class="project-header-right">
                                    @if($project->company_badge)
                                        <span class="project-company-badge">{{ $project->company_badge }}</span>
                                    @endif
                                </div>
                            </div>
                            <h3 class="project-title" id="project-{{ $project->id }}-title">
                                <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                            </h3>
                            @if($project->description)
                                <p class="project-description">{{ $project->description }}</p>
                            @endif
                            @if(count($project->techList()))
                                <div class="project-tech" aria-label="Technologies used">
                                    @foreach($project->techList() as $tech)
                                        <span>{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="project-card-footer">
                                <a href="{{ route('projects.show', $project->slug) }}" class="project-view-link" aria-label="View details for {{ $project->title }}">
                                    View details <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                                <div class="project-quick-links">
                                    @if($project->live_url)
                                        <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" aria-label="View {{ $project->title }} live demo (opens in new tab)">
                                            <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" aria-label="View {{ $project->title }} on GitHub (opens in new tab)">
                                            <i class="fab fa-github" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="contact-section" id="contact" aria-labelledby="contact-heading">
        <div class="container">
            <h2 class="section-title section-title-center contact-heading" id="contact-heading">Have a Project in Mind?</h2>
            <p class="contact-subtitle">Fill in the form to start a conversation</p>

            <div class="contact-grid">
                <div class="contact-info">
                    <h3 id="contact-info-heading">Get in touch</h3>
                    <ul class="contact-details" aria-labelledby="contact-info-heading">
                        <li class="contact-item">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                            <div>
                                <span class="contact-label">Email</span>
                                <a href="mailto:{{ $content->contact_email }}">{{ $content->contact_email }}</a>
                            </div>
                        </li>
                        <li class="contact-item">
                            <i class="fas fa-phone" aria-hidden="true"></i>
                            <div>
                                <span class="contact-label">Phone</span>
                                <a href="tel:{{ preg_replace('/\s+/', '', $content->contact_phone) }}">{{ $content->contact_phone }}</a>
                            </div>
                        </li>
                        <li class="contact-item">
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            <div>
                                <span class="contact-label">Location</span>
                                <span>{{ $content->contact_location }}</span>
                            </div>
                        </li>
                    </ul>
                    <div class="contact-social" aria-label="Social profiles">
                        <a href="{{ $content->linkedin_url }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn (opens in new tab)"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                        <a href="{{ $content->github_url }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub (opens in new tab)"><i class="fab fa-github" aria-hidden="true"></i></a>
                        <a href="mailto:{{ $content->contact_email }}" aria-label="Send email"><i class="fas fa-envelope" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="contact-form-wrapper">
                    @if(session('success'))
                        <div class="alert-success" role="status">
                            <i class="fas fa-check-circle" aria-hidden="true"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any() && ! session('success'))
                        <div class="alert-error" role="alert">
                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                            Please correct the {{ $errors->count() === 1 ? 'error' : 'errors' }} below.
                        </div>
                    @endif
                    <form action="{{ route('contact.store') }}" method="POST" class="contact-form" aria-labelledby="contact-heading" novalidate>
                        @csrf
                        {{-- Honeypot - hidden from real users, bots fill it --}}
                        <div class="hp-field" aria-hidden="true">
                            <label for="website">Leave this empty</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off" value="">
                        </div>
                        <div class="form-group">
                            <label for="contact-name" class="sr-only">Your name</label>
                            <input type="text" name="name" id="contact-name"
                                   placeholder="Your Name" required autocomplete="name"
                                   value="{{ old('name') }}"
                                   {{ $errors->has('name') ? 'aria-invalid=true aria-describedby=contact-name-error' : '' }}>
                            @error('name')
                                <span class="form-error" id="contact-name-error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="contact-email" class="sr-only">Your email</label>
                            <input type="email" name="email" id="contact-email"
                                   placeholder="Your Email" required autocomplete="email"
                                   value="{{ old('email') }}"
                                   {{ $errors->has('email') ? 'aria-invalid=true aria-describedby=contact-email-error' : '' }}>
                            @error('email')
                                <span class="form-error" id="contact-email-error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="contact-subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="contact-subject"
                                   placeholder="Subject" required
                                   value="{{ old('subject') }}"
                                   {{ $errors->has('subject') ? 'aria-invalid=true aria-describedby=contact-subject-error' : '' }}>
                            @error('subject')
                                <span class="form-error" id="contact-subject-error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="contact-message" class="sr-only">Your message</label>
                            <textarea name="message" id="contact-message"
                                      placeholder="Your Message" rows="5" required
                                      {{ $errors->has('message') ? 'aria-invalid=true aria-describedby=contact-message-error' : '' }}>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="form-error" id="contact-message-error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    </main>

    {{-- Footer --}}
    <footer class="footer" aria-labelledby="footer-brand-title">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <span class="logo-text" id="footer-brand-title">DELWAR</span>
                    <p>Building robust web solutions with Laravel & Vue.js</p>
                </div>
                <nav class="footer-links" aria-label="Footer navigation">
                    <a href="#home">Home</a>
                    <a href="#about">About</a>
                    <a href="#experience">Experience</a>
                    <a href="#projects">Projects</a>
                    <a href="#contact">Contact</a>
                </nav>
                <div class="footer-social" aria-label="Social profiles">
                    <a href="{{ $content->linkedin_url }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn (opens in new tab)"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                    <a href="{{ $content->github_url }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub (opens in new tab)"><i class="fab fa-github" aria-hidden="true"></i></a>
                    <a href="mailto:{{ $content->contact_email }}" aria-label="Send email"><i class="fas fa-envelope" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $content->hero_name }}. All Rights Reserved.</p>
                <span class="built-with">Built with <i class="fas fa-heart" aria-label="love"></i> using Laravel</span>
            </div>
        </div>
    </footer>

    {{-- Back to top --}}
    <button class="back-to-top" id="backToTop" type="button" aria-label="Back to top">
        <i class="fas fa-arrow-up" aria-hidden="true"></i>
    </button>

    <script>
        (function () {
            const pre = document.getElementById('page-preloader');
            if (!pre) return;
            let hidden = false;
            function hide() {
                if (hidden) return;
                hidden = true;
                pre.classList.add('preloader-hidden');
                setTimeout(() => pre.remove(), 700);
            }
            window.addEventListener('load', () => setTimeout(hide, 400));
            setTimeout(hide, 4000);
        })();
    </script>
    <script src="{{ asset('js/portfolio.js') }}" defer></script>
</body>
</html>
