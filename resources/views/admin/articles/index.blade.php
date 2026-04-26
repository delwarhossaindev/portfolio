@extends('admin.layout')

@section('title', 'Articles')
@section('header', 'Articles')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-newspaper mr-1"></i> All Articles <span class="badge badge-info ml-2">{{ $items->total() }}</span></h3>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> New Article
            </a>
        </div>
        <div class="card-body p-0">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:60px">#</th>
                        <th><i class="fas fa-heading mr-1"></i> Title</th>
                        <th style="width:160px"><i class="fas fa-tags mr-1"></i> Tags</th>
                        <th style="width:100px">Views</th>
                        <th style="width:120px">Status</th>
                        <th style="width:140px"><i class="far fa-clock mr-1"></i> Published</th>
                        <th style="width:240px; text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td><span class="row-index">{{ $item->id }}</span></td>
                            <td>
                                <div class="user-cell">
                                    @if($item->cover_image)
                                        <span class="avatar-circle" style="background-image: url('{{ asset('storage/' . $item->cover_image) }}'); background-size: cover; background-position: center;"></span>
                                    @else
                                        <span class="avatar-circle" style="background: linear-gradient(135deg,#6366f1,#ec4899)">
                                            <i class="fas fa-feather-pointed"></i>
                                        </span>
                                    @endif
                                    <div class="user-meta">
                                        <div class="user-name">{{ $item->title }}</div>
                                        <div class="user-sub">{{ $item->reading_minutes }} min read</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->tagList())
                                    @foreach(array_slice($item->tagList(), 0, 2) as $tag)
                                        <span class="pill pill-muted">{{ $tag }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td><span class="order-chip">{{ $item->view_count }}</span></td>
                            <td>
                                @if($item->is_published)
                                    <span class="pill pill-success"><i class="fas fa-globe mr-1"></i>Published</span>
                                @else
                                    <span class="pill pill-muted"><i class="fas fa-eye-slash mr-1"></i>Draft</span>
                                @endif
                            </td>
                            <td>
                                @if($item->published_at)
                                    <small class="text-muted">{{ $item->published_at->format('M d, Y') }}</small>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td style="text-align:right">
                                <div class="action-group">
                                    @if($item->slug && Route::has('blog.show'))
                                        <a href="{{ route('blog.show', $item->slug) }}" target="_blank" class="btn btn-edit" title="View on site">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.articles.edit', $item) }}" class="btn btn-edit">
                                        <i class="fas fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.articles.destroy', $item) }}" onsubmit="return confirm('Delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete">
                                            <i class="fas fa-trash-can mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-newspaper"></i>
                                No articles yet. Click "New Article" to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages())
            <div class="card-footer">
                {{ $items->links() }}
            </div>
        @endif
    </div>
@endsection
