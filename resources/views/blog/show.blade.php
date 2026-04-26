<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $article->excerpt ?: Str::limit(strip_tags($article->content), 160) }}">
    <title>{{ $article->title }} - {{ $content->hero_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">
</head>
<body>
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
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
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

    <article class="blog-article">
        <div class="blog-article-hero">
            <div class="container">
                <a href="{{ route('blog.index') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to blog
                </a>

                @unless($article->is_published)
                    <div class="blog-draft-banner">
                        <i class="fas fa-eye-slash"></i> This article is unpublished — only visible to you.
                    </div>
                @endunless

                <div class="blog-article-meta">
                    <span><i class="far fa-calendar"></i> {{ $article->published_at?->format('M d, Y') ?? $article->created_at->format('M d, Y') }}</span>
                    <span><i class="far fa-clock"></i> {{ $article->reading_minutes }} min read</span>
                    <span><i class="far fa-eye"></i> {{ number_format($article->view_count) }} views</span>
                </div>

                <h1 class="blog-article-title">{{ $article->title }}</h1>

                @if($article->excerpt)
                    <p class="blog-article-excerpt">{{ $article->excerpt }}</p>
                @endif

                @if(count($article->tagList()))
                    <div class="blog-card-tags blog-article-tags">
                        @foreach($article->tagList() as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag]) }}">{{ $tag }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        @if($article->coverImageUrl())
            <div class="container">
                <div class="blog-article-cover">
                    <img src="{{ $article->coverImageUrl() }}" alt="{{ $article->title }}" loading="eager">
                </div>
            </div>
        @endif

        <div class="container">
            <div class="blog-article-content prose">
                {!! $article->renderedContent() !!}
            </div>

            <div class="blog-article-share">
                <span>Share this:</span>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </article>

    @if(count($related))
        <section class="related-section">
            <div class="container">
                <h2 class="section-title section-title-center">Related Articles</h2>
                <div class="blog-grid">
                    @foreach($related as $rel)
                        <article class="blog-card">
                            <a href="{{ route('blog.show', $rel->slug) }}" class="blog-card-cover">
                                @if($rel->coverImageUrl())
                                    <img src="{{ $rel->coverImageUrl() }}" alt="{{ $rel->title }}" loading="lazy">
                                @else
                                    <div class="blog-card-cover-placeholder">
                                        <i class="fas fa-feather-pointed"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="blog-card-body">
                                <div class="blog-card-meta">
                                    <span><i class="far fa-calendar"></i> {{ $rel->published_at?->format('M d, Y') ?? $rel->created_at->format('M d, Y') }}</span>
                                    <span><i class="far fa-clock"></i> {{ $rel->reading_minutes }} min</span>
                                </div>
                                <h3 class="blog-card-title">
                                    <a href="{{ route('blog.show', $rel->slug) }}">{{ $rel->title }}</a>
                                </h3>
                                @if($rel->excerpt)
                                    <p class="blog-card-excerpt">{{ Str::limit($rel->excerpt, 100) }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ $content->hero_name }}. All Rights Reserved.</p>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="{{ asset('js/portfolio.js') }}"></script>
</body>
</html>
