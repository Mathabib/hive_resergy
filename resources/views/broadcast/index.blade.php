@extends('layouts.app')

@section('content')
<style>
    /* Full height container dengan background netral */
    .fullpage-container {
        min-height: 100vh;
        background-color: #f9fafb00; /* abu sangat terang / hampir putih */
        color: #333;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        border-bottom: 2px solid #ef4444; /* merah terang */
        padding-bottom: 0.5rem;
    }

    .page-header h2 {
        font-weight: 700;
        font-size: 2rem;
        color: #ffc107; /* merah gelap */
    }

    .btn-create {
        background-color: #ffc107;
        border: none;
        color: rgb(0, 0, 0);
        font-weight: 600;
        text-decoration: none;
        padding: 0.5rem 1.2rem;
        border-radius: 0.5rem;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-create:hover {
        /* background-color: #7f1d1d; */
        background-color: #272727;
        color: white;
        box-shadow: 0 0 8px  #fcf5e0;
    }

    /* Statistik cards */
    .stats-cards {
        display: flex;
        gap: 1.5rem;
    }

    .stats-card {
        flex: 1;
        background: white;
        border-radius: 1rem;
        padding: 1.5rem 2rem;
        box-shadow: 0 4px 10px rgb(185 28 28 / 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #ffc107;
        font-weight: 600;
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 20px rgb(185 28 28 / 0.3);
    }

    .stats-card h5 {
        margin: 0 0 0.25rem 0;
        font-weight: 700;
    }

    .stats-card p {
        font-size: 2.75rem;
        margin: 0;
        font-weight: 900;
        line-height: 1;
    }

    .stats-card i {
        font-size: 3.5rem;
        opacity: 0.3;
    }

    /* Table container */
    .table-container {
        background: white;
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        box-shadow: 0 6px 16px rgb(185 28 28 / 0.15);
        overflow-x: auto;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.75rem;
        color: #444;
    }

    thead th {
        /* background-color: #f87171; */
        background-color: #ffd862;
        font-weight: 700;
        padding: 0.75rem 1rem;
        border-radius: 1rem 1rem 0 0;
        text-align: left;
        color: #7f1d1d; /* merah gelap */
    }

    tbody tr {
        /* background: #fff5f5; merah sangat lembut */
        background-color: #fcf5e0;
        border-radius: 1rem;
        transition: background-color 0.3s ease;
        cursor: default;
    }

    tbody tr:hover {
        /* background: #fca5a5; merah muda sedang */
        background: #ffeaaa;
    }

    tbody td {
        padding: 1rem;
        vertical-align: middle;
        border: none;
    }

    /* Badges */
    .badge-pending {
        background-color: #fbbf24; /* kuning emas */
        color: #713f12;
        font-weight: 700;
        padding: 0.3rem 0.8rem;
        border-radius: 1rem;
        font-size: 0.85rem;
    }

    .badge-sent {
        background-color: #34d399; /* hijau muda */
        font-weight: 700;
        padding: 0.3rem 0.8rem;
        border-radius: 1rem;
        font-size: 0.85rem;
    }

    .badge-failed {
        background-color: #ef4444; /* merah */
        color: white;
        font-weight: 700;
        padding: 0.3rem 0.8rem;
        border-radius: 1rem;
        font-size: 0.85rem;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 1rem;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .stats-cards {
            flex-direction: column;
        }
    }
</style>

<div class="fullpage-container">
    {{-- Header --}}
    <div class="page-header">
        <h2>Broadcast Logs</h2>
        <a href="{{ route('broadcast.create') }}" class="btn-create">
            <i class="bi bi-plus-lg fs-5"></i> Create Broadcast
        </a>
    </div>

    {{-- Statistik --}}
    <div class="stats-cards">
        <div class="stats-card">
            <div>
                <h5>Broadcast Bulan Ini</h5>
                <p>{{ $totalThisMonth }}</p>
            </div>
            <i class="bi bi-calendar3"></i>
        </div>
        <div class="stats-card">
            <div>
                <h5>Broadcast Hari Ini</h5>
                <p>{{ $totalToday }}</p>
            </div>
            <i class="bi bi-calendar-day"></i>
        </div>
    </div>

    {{-- Tabel --}}
 {{-- Tabel --}}
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Sent At</th>
                <th>Error</th>
                <th style="width: 120px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $index => $log)
            <tr>
                <td>{{ $logs->firstItem() + $index }}</td>
                <td class="fw-semibold text-danger">{{ $log->subject }}</td>
                <td>
                    @if($log->status === 'pending')
                        <span class="badge-pending">Pending</span>
                    @elseif($log->status === 'sent')
                        <span class="badge-sent">Sent</span>
                    @else
                        <span class="badge-failed">Failed</span>
                    @endif
                </td>
                <td>{{ $log->sent_at ? $log->sent_at->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') : '-' }}</td>
                <td class="text-danger fst-italic">
                    {{ $log->error_message ?? '-' }}
                </td>
                <td>
                    <!-- <a href="{{ route('broadcast.edit', $log->id) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a> -->

                    <form action="{{ route('broadcast.destroy', $log->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure want to delete this broadcast?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5 fst-italic text-muted">
                    <i class="bi bi-inbox fs-2"></i><br>No broadcast logs found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

 <div class="card-footer clearfix">
              <div class="float-end">
                {{ $logs->links('pagination::bootstrap-5') }}
              </div>
            </div>
</div>

</div>
@endsection
