<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Sport;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Define the 4 standard sports with proper names and icons
        $standardSports = [
            [
                'name' => 'ক্রিকেট',
                'icon' => '🏏',
                'description' => 'ব্যাটিং, পেস ও স্পিন বোলিং এবং নেট প্র্যাকটিস',
            ],
            [
                'name' => 'ফুটবল',
                'icon' => '⚽',
                'description' => 'পেশাদার ফুটবল ড্রিবলিং, পাসিং ও ট্যাকটিক্যাল ট্রেনিং',
            ],
            [
                'name' => 'ব্যাডমিন্টন',
                'icon' => '🏸',
                'description' => 'স্ম্যাশ, ফুটওয়ার্ক ও ইনডোর কোর্ট প্র্যাকটিস',
            ],
            [
                'name' => 'অ্যাথলেটিক্স',
                'icon' => '🏃',
                'description' => 'স্প্রিন্ট, স্ট্যামিনা ও শারীরিক সক্ষমতা বৃদ্ধি',
            ],
        ];

        foreach ($standardSports as $sportData) {
            $existing = Sport::where('name', $sportData['name'])
                ->orWhere('name', 'like', $sportData['name'] . '%')
                ->first();

            if ($existing) {
                $existing->update([
                    'name' => $sportData['name'],
                    'icon' => $sportData['icon'],
                    'description' => $sportData['description'],
                ]);
            } else {
                Sport::create($sportData);
            }
        }

        // Clean up duplicate sports names if any
        $names = ['ক্রিকেট', 'ফুটবল', 'ব্যাডমিন্টন', 'অ্যাথলেটিক্স'];
        foreach ($names as $name) {
            $records = Sport::where('name', $name)->orderBy('id')->get();
            if ($records->count() > 1) {
                $keep = $records->first();
                $duplicates = $records->slice(1);
                foreach ($duplicates as $dup) {
                    // Reassign foreign keys before deleting
                    DB::table('sport_trainee')->where('sport_id', $dup->id)->update(['sport_id' => $keep->id]);
                    DB::table('trainees')->where('sport_id', $dup->id)->update(['sport_id' => $keep->id]);
                    DB::table('coaches')->where('sport_id', $dup->id)->update(['sport_id' => $keep->id]);
                    DB::table('batches')->where('sport_id', $dup->id)->update(['sport_id' => $keep->id]);
                    DB::table('teams')->where('sport_id', $dup->id)->update(['sport_id' => $keep->id]);
                    $dup->delete();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No destructive reverse needed
    }
};
