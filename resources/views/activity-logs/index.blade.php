@extends('layouts.valex')
@section('page-title', 'Activity Logs')
@section('breadcrumb-parent', 'System')
@section('breadcrumb-child', 'Activity Logs')

@section('content')

    <div class="xl:col-span-12 col-span-12">

        <div class="box custom-box mt-3">
            <div class="box-header">
                <div class="box-title">
                    System Activity
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table whitespace-nowrap table-bordered min-w-full">
                        <thead>
                            <tr class="border-b border-defaultborder">
                                <th scope="col" class="text-start">Timestamp</th>
                                <th scope="col" class="text-start">User</th>
                                <th scope="col" class="text-start">Action</th>
                                <th scope="col" class="text-start">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr class="border-b border-defaultborder">
                                    <td>{{ $log->created_at->format('d M Y h:i A') }}</td>
                                    <td>{{ $log->user->name ?? 'System' }}</td>
                                    <td><span class="badge bg-primary/10 text-primary">{{ $log->action }}</span></td>
                                    <td class="whitespace-normal">{{ $log->description }}</td>
                                </tr>
                            @endforeach
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
