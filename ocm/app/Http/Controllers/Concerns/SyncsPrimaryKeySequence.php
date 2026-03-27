<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

trait SyncsPrimaryKeySequence
{
    protected function syncPrimaryKeySequence(Model $model): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $modelClass = get_class($model);
        $usesSoftDeletes = in_array(
            SoftDeletes::class,
            class_uses_recursive($modelClass),
            true
        );

        $query = $usesSoftDeletes
            ? $modelClass::withTrashed()
            : $modelClass::query();

        $maxId = intval($query->max('id'));
        if ($maxId <= 0) {
            return;
        }

        DB::select(
            "SELECT setval(pg_get_serial_sequence(?, 'id'), ?, true)",
            [$model->getTable(), $maxId]
        );
    }
}
