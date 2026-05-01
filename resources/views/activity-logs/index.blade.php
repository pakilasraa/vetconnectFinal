@extends('layouts.valex')
@section('page-title', 'Activity Logs')

@section('styles')
    <style>
        .activity-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .activity-stat-card {
            border: 1px solid rgb(var(--light-rgb) / 0.8);
            border-radius: 0.75rem;
            background: var(--custom-white);
            padding: 0.85rem 1rem;
        }

        .activity-stat-label {
            font-size: 0.75rem;
            color: rgb(var(--text-muted));
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.2rem;
        }

        .activity-stat-value {
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .activity-filter-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.3fr) repeat(4, minmax(0, 1fr)) auto;
            gap: 0.65rem;
            align-items: end;
            margin-bottom: 1rem;
        }

        .activity-table th {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .activity-user-name {
            font-weight: 600;
            line-height: 1.2;
        }

        .activity-meta {
            font-size: 0.72rem;
            color: rgb(var(--text-muted));
            line-height: 1.2;
        }
    </style>
@endsection

@section('content')

    <div class="xl:col-span-12 col-span-12">

        <div class="box custom-box mt-3">
            <div class="box-header">
                <div class="box-title">
                    System Activity
                </div>
            </div>
            <div class="box-body">
                <div class="activity-stats-grid">
                    <div class="activity-stat-card">
                        <div class="activity-stat-label">Total logs</div>
                        <div class="activity-stat-value">{{ number_format($summary['total']) }}</div>
                    </div>
                    <div class="activity-stat-card">
                        <div class="activity-stat-label">Today</div>
                        <div class="activity-stat-value text-primary">{{ number_format($summary['today']) }}</div>
                    </div>
                    <div class="activity-stat-card">
                        <div class="activity-stat-label">System logs</div>
                        <div class="activity-stat-value text-info">{{ number_format($summary['system']) }}</div>
                    </div>
                    <div class="activity-stat-card">
                        <div class="activity-stat-label">Users involved</div>
                        <div class="activity-stat-value text-success">{{ number_format($summary['unique_users']) }}</div>
                    </div>
                </div>

                <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="activity-filter-grid">
                    <div>
                        <label for="search" class="form-label">Search</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-control"
                            value="{{ $search }}"
                            placeholder="Search action or description"
                        >
                    </div>
                    <div>
                        <label for="action" class="form-label">Action</label>
                        <select id="action" name="action" class="form-control">
                            <option value="all" {{ $action === 'all' ? 'selected' : '' }}>All</option>
                            @foreach($actions as $actionName)
                                <option value="{{ $actionName }}" {{ $action === $actionName ? 'selected' : '' }}>{{ $actionName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="user_id" class="form-label">User</label>
                        <select id="user_id" name="user_id" class="form-control">
                            <option value="all" {{ $userId === 'all' ? 'selected' : '' }}>All</option>
                            <option value="0" {{ $userId === '0' ? 'selected' : '' }}>System (auto)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ (string) $userId === (string) $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date_from" class="form-label">From</label>
                        <input type="date" id="date_from" name="date_from" class="form-control" value="{{ $dateFrom }}">
                    </div>
                    <div>
                        <label for="date_to" class="form-label">To</label>
                        <input type="date" id="date_to" name="date_to" class="form-control" value="{{ $dateTo }}">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="ti-btn ti-btn-primary-full ti-btn-wave">Apply</button>
                        <a href="{{ route('admin.activity-logs.index') }}" class="ti-btn ti-btn-light ti-btn-wave">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table whitespace-nowrap table-bordered min-w-full activity-table">
                        <thead>
                            <tr class="border-b border-defaultborder">
                                <th scope="col" class="text-start">#</th>
                                <th scope="col" class="text-start">Timestamp</th>
                                <th scope="col" class="text-start">User</th>
                                <th scope="col" class="text-start">Action</th>
                                <th scope="col" class="text-start">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr class="border-b border-defaultborder">
                                    <td>{{ ($logs->firstItem() ?? 1) + $loop->index }}</td>
                                    <td>
                                        <div>{{ $log->created_at->format('d M Y h:i A') }}</div>
                                        <div class="activity-meta">{{ $log->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td>
                                        <div class="activity-user-name">{{ $log->user->name ?? 'System' }}</div>
                                        <div class="activity-meta">{{ $log->user?->email ?? 'Auto-generated event' }}</div>
                                    </td>
                                    <td><span class="badge bg-primary/10 text-primary">{{ $log->action }}</span></td>
                                    <td class="whitespace-normal">{{ $log->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-textmuted">No activity logs found for the current filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
