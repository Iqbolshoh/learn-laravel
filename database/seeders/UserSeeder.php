<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 10 ta foydalanuvchi yaratish
        User::factory()->count(10)->create();

        $this->command->info('Users table seeded with 10 users!');
    }
}
