@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Broadcast Logs</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Email</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Queued At</th>
                <th>Sent At</th>
                <th>Error</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->email }}</td>
                <td>{{ $log->subject }}</td>
                <td>
                    @if($log->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($log->status == 'sent')
                        <span class="badge bg-success">Sent</span>
                    @else
                        <span class="badge bg-danger">Failed</span>
                    @endif
                </td>
                <td>{{ $log->queued_at }}</td>
                <td>{{ $log->sent_at }}</td>
                <td>{{ $log->error_message }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $logs->links() }}
</div>
@endsection
