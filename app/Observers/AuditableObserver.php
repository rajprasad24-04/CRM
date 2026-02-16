<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditableObserver
{
    public function created(Model $model): void
    {
        $this->log('created', $model, null, $model->getAttributes());
    }

    public function updated(Model $model): void
    {
        $changes = $model->getChanges();
        $oldValues = array_intersect_key($model->getOriginal(), $changes);
        $this->log('updated', $model, $oldValues, $changes);
    }

    public function deleted(Model $model): void
    {
        $this->log('deleted', $model, $model->getOriginal(), null);
    }

    private function log(string $action, Model $model, ?array $oldValues, ?array $newValues): void
    {
        $oldValues = $this->sanitize($model, $oldValues);
        $newValues = $this->sanitize($model, $newValues);

        if ($action === 'updated' && empty($oldValues) && empty($newValues)) {
            return;
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }

    private function sanitize(Model $model, ?array $values): ?array
    {
        if ($values === null) {
            return null;
        }

        $hidden = array_flip(array_merge($model->getHidden() ?? [], ['password', 'remember_token']));

        return array_diff_key($values, $hidden);
    }
}
