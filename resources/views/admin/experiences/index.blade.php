@extends('admin.layout')

@section('title', 'Experiences')
@section('header', 'Experience')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-briefcase mr-1"></i> All Experiences <span class="badge badge-info ml-2">{{ $items->count() }}</span></h3>
            <a href="{{ route('admin.experiences.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> Add Experience
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:60px">#</th>
                        <th><i class="fas fa-user-tie mr-1"></i> Role</th>
                        <th><i class="fas fa-building mr-1"></i> Company</th>
                        <th><i class="far fa-calendar mr-1"></i> Date</th>
                        <th style="width:80px"><i class="fas fa-sort mr-1"></i> Order</th>
                        <th style="width:80px">Active</th>
                        <th style="width:170px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td><span class="badge badge-secondary">{{ $item->id }}</span></td>
                            <td><i class="{{ $item->icon ?: 'fas fa-briefcase' }} mr-1 text-info"></i> {{ $item->role }}</td>
                            <td>{{ $item->company }}</td>
                            <td>{{ $item->date_range }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Yes</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fas fa-times mr-1"></i>No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.experiences.edit', $item) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-pen-to-square"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.experiences.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Delete this experience?');">
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
                                <i class="fas fa-briefcase fa-2x mb-2 d-block" style="opacity:0.4"></i>
                                No experiences yet. Click "Add Experience" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
