<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Coach;
use App\Models\Trainee;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SportsAcademySeeder::class);
        $this->call(TeamAndCricinfoSeeder::class);
        $this->call(CertificateSeeder::class);
        $this->call(PlayerGallerySeeder::class);
        $this->call(TrainingTaskSeeder::class);

        // 1. Admin User
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'একাডেমি এডমিন (Academy Admin)',
                'email' => 'jamesaholland20@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Coach User
        $coach = Coach::first();
        User::updateOrCreate(
            ['email' => 'coach@jamirbaria.com'],
            [
                'name' => ($coach ? $coach->name : 'রফিকুল ইসলাম') . ' (কোচ)',
                'username' => 'coach',
                'password' => Hash::make('password'),
                'role' => 'coach',
                'coach_id' => $coach ? $coach->id : null,
            ]
        );

        // 3. Player User
        $trainee = Trainee::first();
        User::updateOrCreate(
            ['email' => 'player@jamirbaria.com'],
            [
                'name' => ($trainee ? $trainee->name : 'তানভীর আহমেদ সামি') . ' (প্লেয়ার)',
                'username' => 'player',
                'password' => Hash::make('password'),
                'role' => 'player',
                'trainee_id' => $trainee ? $trainee->id : null,
            ]
        );

        // 4. Official Match Scorer User
        User::updateOrCreate(
            ['email' => 'scorer@jamirbaria.com'],
            [
                'name' => 'হাসান মাহমুদ (অফিশিয়াল স্কোরার)',
                'username' => 'scorer',
                'password' => Hash::make('password'),
                'role' => 'scorer',
            ]
        );
    }
}
