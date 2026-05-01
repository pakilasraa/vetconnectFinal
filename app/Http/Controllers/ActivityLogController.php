<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $action = (string) $request->get('action', 'all');
        $userId = (string) $request->get('user_id', 'all');
        $dateFrom = (string) $request->get('date_from', '');
        $dateTo = (string) $request->get('date_to', '');

        $query = ActivityLog::query()->with('user');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($action !== '' && $action !== 'all') {
            $query->where('action', $action);
        }

        if ($userId === '0') {
            $query->whereNull('user_id');
        } elseif ($userId !== '' && $userId !== 'all') {
            $query->where('user_id', (int) $userId);
        }

        if ($dateFrom !== '') {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo !== '') {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $logs = $query->latest()->paginate(20)->appends($request->query());

        $allLogs = ActivityLog::query();
        $summary = [
            'total' => $allLogs->count(),
            'today' => ActivityLog::whereDate('created_at', now()->toDateString())->count(),
            'system' => ActivityLog::whereNull('user_id')->count(),
            'unique_users' => ActivityLog::whereNotNull('user_id')->distinct('user_id')->count('user_id'),
        ];

        $actions = ActivityLog::query()
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $users = \App\Models\User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('activity-logs.index', compact(
            'logs',
            'summary',
            'actions',
            'users',
            'search',
            'action',
            'userId',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityLog $activityLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLog $activityLog)
    {
        //
    }
}
