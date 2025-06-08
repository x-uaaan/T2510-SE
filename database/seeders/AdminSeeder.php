<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'adminName' => 'Alice Smith',
                'adminEmail' => 'alice.smith@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'adminName' => 'Bob Johnson',
                'adminEmail' => 'bob.johnson@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'adminName' => 'Charlie Lee',
                'adminEmail' => 'charlie.lee@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'adminName' => 'Diana King',
                'adminEmail' => 'diana.king@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'adminName' => 'Ethan Brown',
                'adminEmail' => 'ethan.brown@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('admins')->insert($admins);
    }
}
