<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $content->hero_name }} - Portfolio">
    <title>{{ $content->hero_name }} - Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">
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
    <div id="page-preloader" aria-hidden="true">
        <div class="pl-ring">
            <div class="pl-core"></div>
        </div>
        <div class="pl-brand">DELWAR</div>
        <div class="pl-label">loading<span class="pl-dots"></span></div>
    </div>
    {{-- Navigation --}}
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#" class="nav-logo">
                <span class="logo-text">DELWAR</span>
                <div class="logo-eyes">
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
                <li><a href="#contact">Contact</a></li>
                @auth
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge"></i> Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="nav-signin-btn"><i class="fas fa-right-from-bracket"></i> Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('admin.login') }}" class="nav-signin"><i class="fas fa-right-to-bracket"></i> Sign In</a></li>
                @endauth
            </ul>
            <div class="nav-right">
                <div class="theme-switch" id="themeSwitch" title="Toggle Light/Dark Mode">
                    <i class="fas fa-sun"></i>
                    <div class="switch-track">
                        <div class="switch-thumb"></div>
                    </div>
                    <i class="fas fa-moon"></i>
                </div>
                <button class="nav-toggle" id="navToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero" id="home">
        <div class="hero-particles" id="particles"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <p class="hero-greeting">{{ $content->hero_greeting }}</p>
                    <h1 class="hero-name">{{ $content->hero_name }}</h1>
                    <p class="hero-role">I'm a <span class="typed-text" id="typedText" data-roles="{{ $content->hero_roles }}"></span><span class="cursor">|</span></p>
                    <p class="hero-description">{{ $content->hero_description }}</p>
                    <div class="hero-social">
                        <a href="{{ $content->linkedin_url }}" class="social-link" title="LinkedIn" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="{{ $content->github_url }}" class="social-link" title="GitHub" target="_blank"><i class="fab fa-github"></i></a>
                        <a href="mailto:{{ $content->contact_email }}" class="social-link" title="Email"><i class="fas fa-envelope"></i></a>
                    </div>
                    <div class="hero-actions">
                        <a href="#contact" class="btn btn-primary">Hire Me</a>
                        <a href="{{ asset('files/CV_Delwar_Hossain.pdf') }}" class="btn btn-outline" download><i class="fas fa-download"></i> Resume</a>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="image-wrapper">
                        <div class="image-glow"></div>
                        <img src="{{ asset('images/profile.jpg') }}" alt="{{ $content->hero_name }}" class="profile-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About Me Section --}}
    <section class="about-section" id="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <h2 class="section-title">{{ $content->about_title }}</h2>
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
                    <h2 class="section-title">Tech Stack</h2>
                    <div class="tech-grid">
                        {{-- Frontend --}}
                        <div class="tech-icon" title="HTML5">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" alt="HTML5">
                        </div>
                        <div class="tech-icon" title="CSS3">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" alt="CSS3">
                        </div>
                        <div class="tech-icon" title="JavaScript">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript">
                        </div>
                        <div class="tech-icon" title="Vue.js">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg" alt="Vue.js">
                        </div>
                        <div class="tech-icon" title="jQuery">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/jquery/jquery-original.svg" alt="jQuery">
                        </div>
                        <div class="tech-icon" title="Bootstrap">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" alt="Bootstrap">
                        </div>
                        {{-- Backend --}}
                        <div class="tech-icon" title="PHP">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP">
                        </div>
                        <div class="tech-icon" title="Laravel">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg" alt="Laravel">
                        </div>
                        <div class="tech-icon" title="Java">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/java/java-original.svg" alt="Java">
                        </div>
                        {{-- Database --}}
                        <div class="tech-icon" title="MySQL">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="MySQL">
                        </div>
                        <div class="tech-icon" title="Oracle">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/oracle/oracle-original.svg" alt="Oracle">
                        </div>
                        {{-- Tools --}}
                        <div class="tech-icon" title="Git">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg" alt="Git">
                        </div>
                        <div class="tech-icon" title="GitHub">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg" alt="GitHub">
                        </div>
                        <div class="tech-icon" title="Trello">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/trello/trello-plain.svg" alt="Trello">
                        </div>
                        <div class="tech-icon" title="VS Code">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vscode/vscode-original.svg" alt="VS Code">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Work Experience Section --}}
    <section class="experience-section" id="experience">
        <div class="container">
            <h2 class="section-title section-title-center">Work Experience</h2>
            <div class="timeline">
                @foreach($experiences as $exp)
                    <div class="timeline-item">
                        <div class="timeline-dot">
                            <i class="{{ $exp->icon ?: 'fas fa-briefcase' }}"></i>
                        </div>
                        <div class="timeline-content">
                            <h3>{{ $exp->role }}</h3>
                            <span class="timeline-company">{{ $exp->company }}</span>
                            @if($exp->location)
                                <span class="timeline-location"><i class="fas fa-map-marker-alt"></i> {{ $exp->location }}</span>
                            @endif
                            @if($exp->date_range)
                                <span class="timeline-date">{{ $exp->date_range }}</span>
                            @endif
                            @if($exp->description)
                                <p>{{ $exp->description }}</p>
                            @endif
                            @if(count($exp->techList()))
                                <div class="timeline-tech">
                                    @foreach($exp->techList() as $tech)
                                        <span>{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Projects Section --}}
    <section class="projects-section" id="projects">
        <div class="container">
            <h2 class="section-title section-title-center">Projects</h2>
            <div class="projects-grid">
                @foreach($projects as $project)
                    <div class="project-card {{ $project->is_featured ? 'featured' : '' }}">
                        <div class="project-header">
                            <i class="{{ $project->icon ?: 'fas fa-folder-open' }} project-icon"></i>
                            @if($project->company_badge)
                                <div class="project-links">
                                    <span class="project-company-badge">{{ $project->company_badge }}</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="project-title">{{ $project->title }}</h3>
                        @if($project->description)
                            <p class="project-description">{{ $project->description }}</p>
                        @endif
                        @if(count($project->techList()))
                            <div class="project-tech">
                                @foreach($project->techList() as $tech)
                                    <span>{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="contact-section" id="contact">
        <div class="container">
            <h2 class="section-title section-title-center contact-heading">Have a Project in Mind?</h2>
            <p class="contact-subtitle">Fill in the form to start a conversation</p>

            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Get in touch</h3>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <span class="contact-label">Email</span>
                                <a href="mailto:{{ $content->contact_email }}">{{ $content->contact_email }}</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <span class="contact-label">Phone</span>
                                <a href="tel:{{ preg_replace('/\s+/', '', $content->contact_phone) }}">{{ $content->contact_phone }}</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span class="contact-label">Location</span>
                                <span>{{ $content->contact_location }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="contact-social">
                        <a href="{{ $content->linkedin_url }}" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="{{ $content->github_url }}" target="_blank" title="GitHub"><i class="fab fa-github"></i></a>
                        <a href="mailto:{{ $content->contact_email }}" title="Email"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>

                <div class="contact-form-wrapper">
                    @if(session('success'))
                        <div class="alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Your Name" required value="{{ old('name') }}">
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Your Email" required value="{{ old('email') }}">
                            @error('email')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" placeholder="Subject" required value="{{ old('subject') }}">
                            @error('subject')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Your Message" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

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
    <script src="{{ asset('js/portfolio.js') }}"></script>
</body>
</html>
