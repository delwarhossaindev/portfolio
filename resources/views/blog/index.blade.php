<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog articles by {{ $content->hero_name }}">
    <title>Blog - {{ $content->hero_name }}</title>
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
                <li><a href="{{ route('blog.index') }}" class="active">Blog</a></li>
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

    <section class="blog-hero">
        <div class="container">
            <p class="hero-greeting">Articles & Tutorials</p>
            <h1 class="blog-page-title">From the Blog</h1>
            <p class="blog-page-subtitle">Thoughts, insights, and learnings from my journey as a developer.</p>

            <form method="GET" action="{{ route('blog.index') }}" class="blog-search">
                <div class="blog-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="Search articles..." value="{{ $search }}">
                    @if($search)
                        <a href="{{ route('blog.index') }}" class="blog-search-clear" title="Clear">&times;</a>
                    @endif
                </div>
            </form>

            @if(count($allTags))
                <div class="blog-tags-filter">
                    <a href="{{ route('blog.index') }}" class="blog-tag {{ ! $currentTag ? 'active' : '' }}">All</a>
                    @foreach($allTags as $tag)
                        <a href="{{ route('blog.index', ['tag' => $tag]) }}"
                           class="blog-tag {{ $currentTag === $tag ? 'active' : '' }}">{{ $tag }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="blog-list-section">
        <div class="container">
            @if($articles->count())
                <div class="blog-grid">
                    @foreach($articles as $article)
                        <article class="blog-card">
                            <a href="{{ route('blog.show', $article->slug) }}" class="blog-card-cover">
                                @if($article->coverImageUrl())
                                    <img src="{{ $article->coverImageUrl() }}" alt="{{ $article->title }}" loading="lazy">
                                @else
                                    <div class="blog-card-cover-placeholder">
                                        <i class="fas fa-feather-pointed"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="blog-card-body">
                                <div class="blog-card-meta">
                                    <span><i class="far fa-calendar"></i> {{ $article->published_at?->format('M d, Y') ?? $article->created_at->format('M d, Y') }}</span>
                                    <span><i class="far fa-clock"></i> {{ $article->reading_minutes }} min read</span>
                                </div>
                                <h2 class="blog-card-title">
                                    <a href="{{ route('blog.show', $article->slug) }}">{{ $article->title }}</a>
                                </h2>
                                @if($article->excerpt)
                                    <p class="blog-card-excerpt">{{ $article->excerpt }}</p>
                                @endif
                                @if(count($article->tagList()))
                                    <div class="blog-card-tags">
                                        @foreach(array_slice($article->tagList(), 0, 3) as $tag)
                                            <span>{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <a href="{{ route('blog.show', $article->slug) }}" class="blog-card-readmore">
                                    Read article <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="blog-pagination">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="blog-empty">
                    <i class="fas fa-feather-pointed"></i>
                    <h3>No articles yet</h3>
                    <p>
                        @if($search || $currentTag)
                            No articles match your filter. <a href="{{ route('blog.index') }}">Show all</a>
                        @else
                            Check back soon — I'm working on it!
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </section>

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
