<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\TeamPlayer;
use App\Models\PlayerGallery;
use Illuminate\Support\Facades\Storage;

class PlayerGalleryController extends Controller
{
    /**
     * Store new gallery photo for a player
     */
    public function store(Request $request, Trainee $trainee)
    {
        $user = auth()->user();

        // Check if user is authorized (Admin, Coach, or the player themselves)
        $isOwnProfile = $user->trainee_id && $user->trainee_id == $trainee->id;
        $isStaff = $user->isAdmin() || $user->isCoach();

        if (!$isOwnProfile && !$isStaff) {
            abort(403, 'অননুমোদিত অ্যাক্সেস। শুধুমাত্র সংশ্লিষ্ট প্লেয়ার, কোচ বা এডমিন ছবি আপলোড করতে পারেন।');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:match_action,training,celebration,promo,other',
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'description' => 'nullable|string|max:1000',
            'match_name' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
        ]);

        $path = $request->file('photo')->store('player_galleries', 'public');

        $teamPlayer = TeamPlayer::where('trainee_id', $trainee->id)
            ->orWhere('name', $trainee->name)
            ->first();

        PlayerGallery::create([
            'trainee_id' => $trainee->id,
            'team_player_id' => $teamPlayer ? $teamPlayer->id : null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_path' => $path,
            'category' => $validated['category'],
            'match_name' => $validated['match_name'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'uploaded_by' => $user->id,
        ]);

        return back()->with('success', 'গ্যালারিতে নতুন ছবি / প্রোমো মুহূর্ত সফলভাবে যুক্ত করা হয়েছে! 📸');
    }

    /**
     * Delete a gallery photo
     */
    public function destroy(PlayerGallery $gallery)
    {
        $user = auth()->user();

        $isOwnPhoto = $user->trainee_id && $user->trainee_id == $gallery->trainee_id;
        $isUploader = $user->id == $gallery->uploaded_by;
        $isStaff = $user->isAdmin() || $user->isCoach();

        if (!$isOwnPhoto && !$isUploader && !$isStaff) {
            abort(403, 'অননুমোদিত অ্যাক্সেস। আপনি এই ছবিটি মুছে ফেলতে পারবেন না।');
        }

        if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return back()->with('success', 'গ্যালারি থেকে ছবিটি সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Toggle featured status of a gallery photo
     */
    public function toggleFeatured(PlayerGallery $gallery)
    {
        $user = auth()->user();

        $isOwnPhoto = $user->trainee_id && $user->trainee_id == $gallery->trainee_id;
        $isStaff = $user->isAdmin() || $user->isCoach();

        if (!$isOwnPhoto && !$isStaff) {
            abort(403, 'অননুমোদিত অ্যাক্সেস।');
        }

        $gallery->update([
            'is_featured' => !$gallery->is_featured,
        ]);

        $status = $gallery->is_featured ? 'ফিচার্ড তালিকায় যুক্ত করা হয়েছে!' : 'ফিচার্ড তালিকা থেকে বাদ দেওয়া হয়েছে!';

        return back()->with('success', $status);
    }
}

