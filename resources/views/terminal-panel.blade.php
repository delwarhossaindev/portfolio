@extends('admin.layout')

@section('title', 'Terminal Panel')
@section('header', 'Terminal Panel')

@push('styles')
<style>
    .term-badge {
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(34, 197, 94, 0.15);
        border: 1px solid rgba(34, 197, 94, 0.35);
        color: #86efac;
        font-size: 12px;
    }
    .chip {
        border: 1px solid #3d4f77;
        background: #12203d;
        color: #bdd0ff;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        cursor: pointer;
    }
    .chip:hover { background: #1a2f5c; }
    .console {
        background: #060d1d;
        border: 1px solid #2f3f61;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 16px;
    }
    .console-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        background: #0d1831;
        border-bottom: 1px solid #263858;
        font-size: 13px;
        color: #9fb0d1;
    }
    .status-success { color: #22c55e; font-weight: 600; }
    .status-failed { color: #ef4444; font-weight: 600; }
    .console pre {
        margin: 0;
        padding: 14px;
        color: #dbeafe;
        font-size: 13px;
        line-height: 1.55;
        white-space: pre-wrap;
        word-break: break-word;
        max-height: 360px;
        overflow: auto;
    }
    .block-label {
        margin: 12px 14px 0;
        color: #9fb0d1;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.7px;
    }
    .empty-terminal {
        border: 1px dashed #3a4c72;
        border-radius: 8px;
        padding: 24px;
        text-align: center;
        color: #9fb0d1;
        font-size: 14px;
        margin-top: 16px;
    }
</style>
@endpush

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Run Command</h3>
            <span class="term-badge">Project Root: {{ base_path() }}</span>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 style="font-size:20px">{{ app()->environment() }}</h3>
                            <p>Environment</p>
                        </div>
                        <div class="icon"><i class="fas fa-cog"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3 style="font-size:20px">{{ session('exit_code', 'N/A') }}</h3>
                            <p>Last Exit Code</p>
                        </div>
                        <div class="icon"><i class="fas fa-hashtag"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    @if(session()->has('successful'))
                        <div class="small-box {{ session('successful') ? 'bg-success' : 'bg-danger' }}">
                            <div class="inner">
                                <h3 style="font-size:20px">{{ session('successful') ? 'Success' : 'Failed' }}</h3>
                                <p>Last Status</p>
                            </div>
                            <div class="icon"><i class="fas fa-circle-check"></i></div>
                        </div>
                    @else
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 style="font-size:20px">No command</h3>
                                <p>Last Status</p>
                            </div>
                            <div class="icon"><i class="fas fa-hourglass-start"></i></div>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route('terminal.run') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input
                        id="commandInput"
                        type="text"
                        name="command"
                        class="form-control"
                        placeholder="Example: php artisan optimize:clear"
                        value="{{ old('command', session('command')) }}"
                        required
                    >
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-terminal mr-1"></i> Run</button>
                    </div>
                </div>
            </form>

            <div class="mt-3 d-flex flex-wrap" style="gap:8px">
                <button class="chip" type="button" data-command="php artisan route:list">route:list</button>
                <button class="chip" type="button" data-command="php artisan cache:clear">cache:clear</button>
                <button class="chip" type="button" data-command="php artisan config:clear">config:clear</button>
                <button class="chip" type="button" data-command="php artisan optimize:clear">optimize:clear</button>
                <button class="chip" type="button" data-command="php artisan migrate:status">migrate:status</button>
            </div>

            @error('command')
                <p class="text-danger mt-2">{{ $message }}</p>
            @enderror

            @if(session()->has('exit_code'))
                <div class="console">
                    <div class="console-head">
                        <span><strong>$</strong> {{ session('command') }}</span>
                        <span class="{{ session('successful') ? 'status-success' : 'status-failed' }}">
                            {{ session('successful') ? 'Success' : 'Failed' }} (Exit: {{ session('exit_code') }})
                        </span>
                    </div>
                    <p class="block-label">Standard Output</p>
                    <pre>{{ session('output') ?: 'No standard output.' }}</pre>
                    @if(session('error_output'))
                        <p class="block-label">Error Output</p>
                        <pre>{{ session('error_output') }}</pre>
                    @endif
                </div>
            @else
                <div class="empty-terminal">
                    No command executed yet. Use the input field or quick command chips.
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.chip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            document.getElementById('commandInput').value = chip.getAttribute('data-command');
            document.getElementById('commandInput').focus();
        });
    });
</script>
@endpush
