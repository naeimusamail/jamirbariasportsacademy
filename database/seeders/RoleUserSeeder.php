<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Coach;
use App\Models\Trainee;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@jamirbaria.com'],
            [
                'name' => 'একাডেমি এডমিন (Academy Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'coach_id' => null,
                'trainee_id' => null,
            ]
        );

        // 2. Coach User
        $coach = Coach::first();
        User::updateOrCreate(
            ['email' => 'coach@jamirbaria.com'],
            [
                'name' => ($coach ? $coach->name : 'রফিকুল ইসলাম') . ' (কোচ)',
                'password' => Hash::make('password'),
                'role' => 'coach',
                'coach_id' => $coach ? $coach->id : null,
                'trainee_id' => null,
            ]
        );

        // 3. Player User
        $trainee = Trainee::first();
        User::updateOrCreate(
            ['email' => 'player@jamirbaria.com'],
            [
                'name' => ($trainee ? $trainee->name : 'তানভীর আহমেদ সামি') . ' (প্লেয়ার)',
                'password' => Hash::make('password'),
                'role' => 'player',
                'coach_id' => null,
                'trainee_id' => $trainee ? $trainee->id : null,
            ]
        );
    }
}
