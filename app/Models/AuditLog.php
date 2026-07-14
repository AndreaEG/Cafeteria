<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'table_name', 'record_id',
        'old_values', 'new_values', 'ip_address',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public static function log(string $action, string $table, int $recordId, ?array $old = null, ?array $new = null): void
    {
        self::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'table_name' => $table,
            'record_id'  => $recordId,
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => request()->ip(),
        ]);
    }
}
