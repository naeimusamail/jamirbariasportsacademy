<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
        });

        // Seed existing usernames based on known accounts
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $username = match($user->email) {
                'admin@jamirbaria.com' => 'admin',
                'coach@jamirbaria.com' => 'coach',
                'player@jamirbaria.com' => 'player',
                'scorer@jamirbaria.com' => 'scorer',
                default => Str::slug(explode('@', $user->email)[0]),
            };

            // Ensure uniqueness
            $candidate = $username;
            $count = 1;
            while (DB::table('users')->where('username', $candidate)->where('id', '!=', $user->id)->exists()) {
                $candidate = $username . $count;
                $count++;
            }

            DB::table('users')->where('id', $user->id)->update(['username' => $candidate]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};

