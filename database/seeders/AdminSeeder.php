<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@iqbolshoh.uz',
            'username' => 'superadmin',
            'password' => Hash::make('IQBOLSHOH'),
        ]);

        // 10 ta random admin yaratish
        Admin::factory()->count(10)->create();

        $this->command->info('Admins table seeded with 11 admins!');
    }
}
