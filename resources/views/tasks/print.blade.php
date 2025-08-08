<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Detail</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #2c3e50;
            margin: 0;
            padding-bottom: 5px;
        }

        .logo {
            width: 120px;
            height: auto;
        }

        .section {
            margin-bottom: 25px;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 130px;
            color: #555;
        }

        .value {
            color: #111;
        }

        .info-row {
            margin-bottom: 8px;
        }

        ul {
            padding-left: 18px;
        }

        li {
            margin-bottom: 4px;
        }

        .comment {
            background-color: #f1f1f1;
            border-left: 4px solid #3498db;
            padding: 10px;
            margin-bottom: 10px;
        }

        .comment strong {
            color: #2c3e50;
        }

        .section-title {
            font-size: 16px;
            margin-bottom: 10px;
            color: #2c3e50;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #888;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2 class="title">Task Detail</h2>
        <!-- <img src="{{ public_path('images/logo-isol.png') }}" class="logo" alt="Logo"> -->
    </div>

    <div class="section">
        <div class="info-row">
            <span class="label">Nama Task:</span>
            <span class="value">{{ $task->nama_task }}</span>
        </div>
        <div class="info-row">
            <span class="label">Project:</span>
            <span class="value">{{ $task->project->nama ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Status:</span>
            <span class="value">{{ ucfirst($task->status) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Start Date:</span>
            <span class="value">{{ $task->start_date }}</span>
        </div>
        <div class="info-row">
            <span class="label">End Date:</span>
            <span class="value">{{ $task->end_date }}</span>
        </div>
        <div class="info-row">
            <span class="label">Durasi Estimasi:</span>
            <span class="value">{{ $estimate }} hari</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Assignee</div>
        <ul>
            @forelse ($task->assignedUsers as $user)
                <li>{{ $user->name }}</li>
            @empty
                <li><i>No assignee</i></li>
            @endforelse
        </ul>
    </div>

    <div class="section">
        <div class="section-title">Comments</div>
        @forelse ($task->comments as $comment)
            <div class="comment">
                <strong>{{ $comment->user->name }}</strong><br>
                {{ $comment->content }}
            </div>
        @empty
            <p><i>Tidak ada komentar.</i></p>
        @endforelse
    </div>

    <div class="footer">
        Automatically printed by the system on {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
    </div>

</body>
</html>
