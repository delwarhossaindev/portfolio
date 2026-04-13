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
</head>
<body>
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
                {{-- 1. ACI Limited --}}
                <div class="timeline-item">
                    <div class="timeline-dot">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Software Engineer</h3>
                        <span class="timeline-company">ACI Limited</span>
                        <span class="timeline-location"><i class="fas fa-map-marker-alt"></i> ACI Centre 245, Tejgaon Industrial Area, Dhaka-1208</span>
                        <span class="timeline-date">March 2024 - Present (1.7 yrs)</span>
                        <p>Writing clean and efficient code in PHP (Laravel). Troubleshooting, testing, and maintaining applications and databases. Taking ownership & full responsibility for projects. Building effective REST APIs with extendable, manageable, and secured code.</p>
                        <div class="timeline-tech">
                            <span>Laravel</span>
                            <span>Vue.js</span>
                            <span>REST API</span>
                        </div>
                    </div>
                </div>

                {{-- 2. MBM Group --}}
                <div class="timeline-item">
                    <div class="timeline-dot">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Software Engineer</h3>
                        <span class="timeline-company">MBM Group</span>
                        <span class="timeline-location"><i class="fas fa-map-marker-alt"></i> Mirpur DOHS, Dhaka</span>
                        <span class="timeline-date">June 2022 - February 2024 (1.7 yrs)</span>
                        <p>Worked on Merchandising, Commercial, Store, Industrial Engineering (IE), and Purchase modules. Ensured extendable, manageable, and secured code. Used version control, debug tools, and monitoring processes.</p>
                        <div class="timeline-tech">
                            <span>Laravel</span>
                            <span>Vue.js</span>
                            <span>MySQL</span>
                            <span>Oracle</span>
                            <span>GitHub</span>
                            <span>Trello</span>
                        </div>
                    </div>
                </div>

                {{-- 3. Ringer Soft Limited --}}
                <div class="timeline-item">
                    <div class="timeline-dot">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Software Engineer</h3>
                        <span class="timeline-company">Ringer Soft Limited</span>
                        <span class="timeline-location"><i class="fas fa-map-marker-alt"></i> Chittagong</span>
                        <span class="timeline-date">October 2020 - May 2022 (1.6 yrs)</span>
                        <p>Took ownership of back-end development and front-end on multiple projects. Worked on HR & Payroll, Inventory, POS, and School Management System. Handled project requirement analysis and client discussions.</p>
                        <div class="timeline-tech">
                            <span>Laravel</span>
                            <span>JavaScript</span>
                            <span>jQuery</span>
                            <span>MySQL</span>
                            <span>SSLCOMMERZ</span>
                        </div>
                    </div>
                </div>

                {{-- 4. ICT Wing (BAIUST) --}}
                <div class="timeline-item">
                    <div class="timeline-dot">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Jr. Software Engineer</h3>
                        <span class="timeline-company">ICT Wing (BAIUST)</span>
                        <span class="timeline-location"><i class="fas fa-map-marker-alt"></i> Cumilla Cantonment</span>
                        <span class="timeline-date">January 2020 - September 2020 (0.7 yr)</span>
                        <p>Worked on Online Exam Registration System (Admission, Semester & Referred Exam) and Online Based Android Application. Collaborated with development teams and product managers.</p>
                        <div class="timeline-tech">
                            <span>PHP</span>
                            <span>Laravel</span>
                            <span>JavaScript</span>
                            <span>jQuery</span>
                            <span>MySQL</span>
                            <span>Java</span>
                        </div>
                    </div>
                </div>

                {{-- Education --}}
                <div class="timeline-item">
                    <div class="timeline-dot">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>BSc in Computer Science & Engineering</h3>
                        <span class="timeline-company">Bangladesh Army International University of Science and Technology (BAIUST)</span>
                        <span class="timeline-date">Graduated 2020 | 4 Years | 161 Credits</span>
                        <p>Completed Bachelor of Science degree in Computer Science & Engineering with a strong foundation in software development, algorithms, data structures, and engineering principles.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Projects Section --}}
    <section class="projects-section" id="projects">
        <div class="container">
            <h2 class="section-title section-title-center">Projects</h2>
            <div class="projects-grid">
                {{-- ACI Limited Projects --}}
                <div class="project-card featured">
                    <div class="project-header">
                        <i class="fas fa-building project-icon"></i>
                        <div class="project-links">
                            <span class="project-company-badge">ACI Limited</span>
                        </div>
                    </div>
                    <h3 class="project-title">Enterprise Web Application</h3>
                    <p class="project-description">
                        Full-scale enterprise application at ACI Limited. Writing clean and efficient code,
                        troubleshooting and maintaining applications and databases. Building effective REST APIs
                        with extendable, manageable, and secured architecture.
                    </p>
                    <div class="project-tech">
                        <span>Laravel</span>
                        <span>Vue.js</span>
                        <span>REST API</span>
                        <span>MySQL</span>
                    </div>
                </div>

                {{-- MBM Group ERP --}}
                <div class="project-card featured">
                    <div class="project-header">
                        <i class="fas fa-industry project-icon"></i>
                        <div class="project-links">
                            <span class="project-company-badge">MBM Group</span>
                        </div>
                    </div>
                    <h3 class="project-title">ERP System - Merchandising, Commercial, Store, IE & Purchase</h3>
                    <p class="project-description">
                        Comprehensive ERP solution covering Merchandising, Commercial, Store, Industrial Engineering (IE),
                        and Purchase modules. Built with version control, debug tools, and monitoring processes
                        for enterprise-level operations.
                    </p>
                    <div class="project-tech">
                        <span>Laravel</span>
                        <span>Vue.js</span>
                        <span>MySQL</span>
                        <span>Oracle</span>
                        <span>Trello</span>
                    </div>
                </div>

                {{-- Ringer Soft Projects --}}
                <div class="project-card">
                    <div class="project-header">
                        <i class="fas fa-folder-open project-icon"></i>
                        <div class="project-links">
                            <span class="project-company-badge">Ringer Soft</span>
                        </div>
                    </div>
                    <h3 class="project-title">HR & Payroll, Inventory, POS System</h3>
                    <p class="project-description">
                        Multiple enterprise solutions including HR & Payroll management, Inventory tracking system,
                        and Point of Sale (POS) system. Handled requirement analysis, client discussions, and project deadline management.
                    </p>
                    <div class="project-tech">
                        <span>Laravel</span>
                        <span>JavaScript</span>
                        <span>jQuery</span>
                        <span>MySQL</span>
                        <span>SSLCOMMERZ</span>
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-header">
                        <i class="fas fa-school project-icon"></i>
                        <div class="project-links">
                            <span class="project-company-badge">Ringer Soft</span>
                        </div>
                    </div>
                    <h3 class="project-title">School Management System</h3>
                    <p class="project-description">
                        Complete school management solution with student enrollment, attendance tracking,
                        grade management, and administrative tools. Full back-end and front-end ownership
                        with clear, well-documented code.
                    </p>
                    <div class="project-tech">
                        <span>Laravel</span>
                        <span>JavaScript</span>
                        <span>jQuery</span>
                        <span>MySQL</span>
                    </div>
                </div>

                {{-- BAIUST Projects --}}
                <div class="project-card">
                    <div class="project-header">
                        <i class="fas fa-laptop-code project-icon"></i>
                        <div class="project-links">
                            <span class="project-company-badge">BAIUST</span>
                        </div>
                    </div>
                    <h3 class="project-title">Online Exam Registration System</h3>
                    <p class="project-description">
                        Online Exam Registration System handling Admission, Semester & Referred Exam registrations.
                        Designed for Cumilla Cantonment's ICT Wing with efficient data management and user-friendly interface.
                    </p>
                    <div class="project-tech">
                        <span>PHP</span>
                        <span>Laravel</span>
                        <span>JavaScript</span>
                        <span>jQuery</span>
                        <span>MySQL</span>
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-header">
                        <i class="fas fa-mobile-alt project-icon"></i>
                        <div class="project-links">
                            <span class="project-company-badge">BAIUST</span>
                        </div>
                    </div>
                    <h3 class="project-title">Online Based Android Application</h3>
                    <p class="project-description">
                        Android-based mobile application developed for BAIUST ICT Wing.
                        Built with Java and integrated with web backend for seamless data synchronization
                        and user experience.
                    </p>
                    <div class="project-tech">
                        <span>Java</span>
                        <span>PHP</span>
                        <span>MySQL</span>
                        <span>Android</span>
                    </div>
                </div>
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

    <script src="{{ asset('js/portfolio.js') }}"></script>
</body>
</html>
