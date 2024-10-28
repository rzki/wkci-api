<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // User::factory(10)->create();

        $superadmin = User::create([
            'userId' => Str::orderedUuid(),
            'name' => 'Superadmin',
            'email' => 'itd@kpopworld.id',
            'password' => Hash::make('Superadmin2024!')
        ]);

        return $superadmin;
    }
}
