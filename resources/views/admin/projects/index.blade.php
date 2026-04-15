@extends('admin.layout')

@section('title', 'Projects')
@section('header', 'Projects')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-diagram-project mr-1"></i> All Projects <span class="badge badge-info ml-2">{{ $items->count() }}</span></h3>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> Add Project
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:60px">#</th>
                        <th><i class="fas fa-heading mr-1"></i> Title</th>
                        <th><i class="fas fa-tag mr-1"></i> Badge</th>
                        <th style="width:100px">Featured</th>
                        <th style="width:80px"><i class="fas fa-sort mr-1"></i> Order</th>
                        <th style="width:80px">Active</th>
                        <th style="width:170px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td><span class="badge badge-secondary">{{ $item->id }}</span></td>
                            <td><i class="{{ $item->icon ?: 'fas fa-folder-open' }} mr-1 text-warning"></i> {{ $item->title }}</td>
                            <td>{{ $item->company_badge }}</td>
                            <td>
                                @if($item->is_featured)
                                    <span class="badge badge-warning"><i class="fas fa-star mr-1"></i>Featured</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </td>
                            <td>{{ $item->sort_order }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Yes</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fas fa-times mr-1"></i>No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.projects.edit', $item) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-pen-to-square"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Delete this project?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-can"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-diagram-project fa-2x mb-2 d-block" style="opacity:0.4"></i>
                                No projects yet. Click "Add Project" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
