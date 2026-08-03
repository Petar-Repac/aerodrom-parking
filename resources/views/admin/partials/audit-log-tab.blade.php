<h2 class="h5 mb-3">Audit Log</h2>

<table class="table table-sm table-striped align-middle">
    <thead>
    <tr>
        <th>When</th>
        <th>Admin</th>
        <th>Action</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($auditLogs as $log)
        <tr>
            <td class="text-nowrap">{{ $log->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ $log->user?->name ?? '—' }}</td>
            <td><code>{{ $log->action }}</code></td>
            <td>
                {{ $log->description }}
                @if ($log->changes)
                    <details class="small text-muted">
                        <summary>Details</summary>
                        <pre class="mb-0">{{ json_encode($log->changes, JSON_PRETTY_PRINT) }}</pre>
                    </details>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center text-muted">No activity yet.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $auditLogs->links('pagination::bootstrap-5') }}
