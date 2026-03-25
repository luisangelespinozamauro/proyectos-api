<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        AuditLog::create([
            'user_id' => 1,
            'action' => 'create',
            'table_name' => 'projects',
            'record_id' => 1,
            'new_values' => json_encode([
                'brand' => 'Toyota',
                'model' => 'Hilux'
            ])
        ]);
    }
}
