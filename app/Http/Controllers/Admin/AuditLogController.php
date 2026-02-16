<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->orderByDesc('created_at');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }
        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }
        if ($request->filled('model')) {
            $query->where('auditable_type', $request->input('model'));
        }
        if ($request->filled('record_id')) {
            $query->where('auditable_id', $request->input('record_id'));
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        if ($request->input('export') === 'csv') {
            return $this->exportCsv(clone $query);
        }

        $logs = $query->paginate(20)->withQueryString();
        $users = User::orderBy('name')->get(['id', 'name', 'email']);
        $actions = AuditLog::select('action')->distinct()->pluck('action');
        $models = AuditLog::select('auditable_type')->distinct()->pluck('auditable_type');

        return view('admin.audit_logs.index', compact('logs', 'users', 'actions', 'models'));
    }

    public function show(AuditLog $auditLog)
    {
        $oldValues = $auditLog->old_values ?? [];
        $newValues = $auditLog->new_values ?? [];
        $allKeys = collect(array_keys($oldValues + $newValues))->sort()->values();

        $diff = $allKeys->map(function ($key) use ($oldValues, $newValues) {
            return [
                'field' => $key,
                'old' => $oldValues[$key] ?? null,
                'new' => $newValues[$key] ?? null,
                'changed' => ($oldValues[$key] ?? null) !== ($newValues[$key] ?? null),
            ];
        });

        return view('admin.audit_logs.show', compact('auditLog', 'diff'));
    }

    private function exportCsv($query): StreamedResponse
    {
        $filename = 'audit_logs_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Time', 'User', 'Action', 'Model', 'Record ID', 'IP']);

            $query->chunk(500, function ($logs) use ($handle) {
                foreach ($logs as $log) {
                    fputcsv($handle, [
                        $log->created_at?->format('Y-m-d H:i:s'),
                        $log->user?->email ?? 'System',
                        $log->action,
                        class_basename($log->auditable_type),
                        $log->auditable_id,
                        $log->ip_address,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
