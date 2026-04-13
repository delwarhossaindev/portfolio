<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Terminal Panel</title>
    <style>
        :root {
            --bg-main: #0f172a;
            --bg-card: #111c34;
            --bg-soft: #1e2b4a;
            --line: #31456d;
            --text-main: #e2e8f0;
            --text-soft: #9fb0d1;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f59e0b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top right, #162447 0%, var(--bg-main) 50%);
            color: var(--text-main);
            min-height: 100vh;
        }

        .layout {
            max-width: 1120px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .title h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .title p {
            margin: 6px 0 0;
            color: var(--text-soft);
            font-size: 14px;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.35);
            color: #86efac;
            font-size: 12px;
            white-space: nowrap;
        }

        .grid {
            display: grid;
            gap: 16px;
            grid-template-columns: 1fr 1fr 1fr;
            margin-bottom: 16px;
        }

        .stat {
            background: rgba(17, 28, 52, 0.82);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 14px;
        }

        .stat span {
            display: block;
            font-size: 12px;
            color: var(--text-soft);
            margin-bottom: 4px;
        }

        .stat strong {
            font-size: 16px;
            font-weight: 600;
        }

        .panel {
            background: rgba(17, 28, 52, 0.85);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 24px 60px rgba(3, 7, 18, 0.35);
        }

        .panel h2 {
            margin: 0 0 14px;
            font-size: 20px;
        }

        .row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .row input[type="text"] {
            flex: 1;
            min-width: 240px;
            border: 1px solid var(--line);
            background: #0c1427;
            color: var(--text-main);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .quick-commands {
            margin-top: 14px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .chip {
            border: 1px solid #3d4f77;
            background: #12203d;
            color: #bdd0ff;
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 12px;
            cursor: pointer;
        }

        .chip:hover {
            background: #1a2f5c;
        }

        .error {
            margin-top: 10px;
            color: #fca5a5;
            font-size: 13px;
        }

        .console {
            margin-top: 16px;
            background: #060d1d;
            border: 1px solid #2f3f61;
            border-radius: 12px;
            overflow: hidden;
        }

        .console-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            background: #0d1831;
            border-bottom: 1px solid #263858;
            font-size: 13px;
            color: var(--text-soft);
        }

        .status-success {
            color: var(--success);
            font-weight: 600;
        }

        .status-failed {
            color: var(--danger);
            font-weight: 600;
        }

        pre {
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
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .empty {
            margin-top: 16px;
            border: 1px dashed #3a4c72;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            color: #9fb0d1;
            font-size: 14px;
        }

        @media (max-width: 860px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <div class="topbar">
            <div class="title">
                <h1>Admin Terminal</h1>
                <p>Run project commands from a clean admin-style console interface.</p>
            </div>
            <div class="badge">Project Root: {{ base_path() }}</div>
        </div>

        <div class="grid">
            <div class="stat">
                <span>Environment</span>
                <strong>{{ app()->environment() }}</strong>
            </div>
            <div class="stat">
                <span>Last Exit Code</span>
                <strong>{{ session('exit_code', 'N/A') }}</strong>
            </div>
            <div class="stat">
                <span>Last Status</span>
                @if(session()->has('successful'))
                    <strong style="color: {{ session('successful') ? '#22c55e' : '#ef4444' }}">
                        {{ session('successful') ? 'Success' : 'Failed' }}
                    </strong>
                @else
                    <strong style="color: #f59e0b">No command yet</strong>
                @endif
            </div>
        </div>

        <div class="panel">
            <h2>Run Command</h2>
            <form action="{{ route('terminal.run') }}" method="POST">
                @csrf
                <div class="row">
                    <input
                        id="commandInput"
                        type="text"
                        name="command"
                        placeholder="Example: php artisan optimize:clear"
                        value="{{ old('command', session('command')) }}"
                        required
                    >
                    <button class="btn btn-primary" type="submit">Run</button>
                </div>
            </form>

            <div class="quick-commands">
                <button class="chip" type="button" data-command="php artisan route:list">route:list</button>
                <button class="chip" type="button" data-command="php artisan cache:clear">cache:clear</button>
                <button class="chip" type="button" data-command="php artisan config:clear">config:clear</button>
                <button class="chip" type="button" data-command="php artisan optimize:clear">optimize:clear</button>
                <button class="chip" type="button" data-command="php artisan migrate:status">migrate:status</button>
            </div>

            @error('command')
                <p class="error">{{ $message }}</p>
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
                <div class="empty">
                    No command executed yet. Use the input field or quick command chips.
                </div>
            @endif
        </div>
    </div>

    <script>
        document.querySelectorAll('.chip').forEach(function (chip) {
            chip.addEventListener('click', function () {
                document.getElementById('commandInput').value = chip.getAttribute('data-command');
                document.getElementById('commandInput').focus();
            });
        });
    </script>
</body>
</html>
