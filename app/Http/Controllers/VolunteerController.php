<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Models\Tournament;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VolunteerController extends Controller
{
    /**
     * Show Public Volunteer Application Form
     */
    public function create()
    {
        $data = \App\Http\Controllers\ApplicationHubController::getData(request(), 'volunteer');
        return view('apply.index', $data);
    }

    /**
     * Store Volunteer Application
     */
    public function store(Request $request)
    {
        // Enforce circular start / deadline gate
        $circular = \App\Models\RegistrationCircular::ofType('volunteer');
        if (!$circular->isOpen()) {
            $msg = $circular->isUpcoming()
                ? ($circular->upcoming_message ?: 'ভলান্টিয়ার আবেদন প্রক্রিয়া এখনও শুরু হয়নি। শুরুর সময়: ' . ($circular->start_date ? $circular->start_date->format('d M Y, h:i A') : 'শীঘ্রই'))
                : ($circular->closed_message ?: 'ভলান্টিয়ার আবেদন প্রক্রিয়া বর্তমানে বন্ধ রয়েছে বা সময়সীমা সমাপ্ত হয়েছে।');
            return back()->withInput()->with('error', $msg);
        }

        // Auto convert Bengali digits to English digits
        $bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $enDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        if ($request->filled('phone')) {
            $request->merge(['phone' => str_replace($bnDigits, $enDigits, $request->phone)]);
        }
        if ($request->filled('emergency_phone')) {
            $request->merge(['emergency_phone' => str_replace($bnDigits, $enDigits, $request->emergency_phone)]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+ -]+$/'],
            'emergency_phone' => ['nullable', 'string', 'max:25', 'regex:/^[0-9+ -]+$/'],
            'email' => 'nullable|email|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:10',
            'tshirt_size' => 'required|in:S,M,L,XL,XXL',
            'department' => 'required|string|max:100',
            'organization_or_institution' => 'nullable|string|max:255',
            'address' => 'required|string|max:1000',
            'experience' => 'nullable|string|max:1500',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'cropped_photo' => 'nullable|string',
        ]);

        // Handle Cropped Photo (300x300 base64) or regular file upload
        $photoPath = null;
        if ($request->filled('cropped_photo') && str_starts_with($request->cropped_photo, 'data:image')) {
            $image_parts = explode(";base64,", $request->cropped_photo);
            if (isset($image_parts[1])) {
                $image_base64 = base64_decode($image_parts[1]);
                $filename = 'volunteers/' . Str::random(40) . '.jpg';
                Storage::disk('public')->put($filename, $image_base64);
                $photoPath = $filename;
            }
        } elseif ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('volunteers', 'public');
        }

        $volunteerNo = Volunteer::generateVolunteerNo();

        $volunteer = Volunteer::create([
            'volunteer_no' => $volunteerNo,
            'name' => $validated['name'],
            'name_en' => $validated['name_en'] ?? null,
            'phone' => $validated['phone'],
            'emergency_phone' => $validated['emergency_phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'],
            'blood_group' => $validated['blood_group'] ?? null,
            'tshirt_size' => $validated['tshirt_size'],
            'department' => $validated['department'],
            'organization_or_institution' => $validated['organization_or_institution'] ?? null,
            'address' => $validated['address'],
            'experience' => $validated['experience'] ?? null,
            'tournament_id' => $validated['tournament_id'] ?? null,
            'photo' => $photoPath,
            'status' => 'pending',
        ]);

        return redirect()->route('volunteer.tracking', $volunteer->volunteer_no)
            ->with('success', 'আপনার ভলান্টিয়ার আবেদনটি সফলভাবে গৃহীত হয়েছে! আবেদন ট্র্যাকিং নম্বরটি সংরক্ষণ করুন।');
    }

    /**
     * Volunteer Tracking Page
     */
    public function tracking($volunteer_no)
    {
        $volunteer = Volunteer::with('tournament')->where('volunteer_no', $volunteer_no)->firstOrFail();
        return view('volunteer.tracking', compact('volunteer'));
    }

    /**
     * Search tracking by number or phone
     */
    public function trackSearch(Request $request)
    {
        $query = trim($request->input('query'));
        if (!$query) {
            return redirect()->route('volunteer.create');
        }

        $volunteer = Volunteer::where('volunteer_no', $query)
            ->orWhere('phone', $query)
            ->first();

        if (!$volunteer) {
            return back()->with('error', 'প্রদত্ত নম্বর দিয়ে কোনো ভলান্টিয়ার আবেদন পাওয়া যায়নি।');
        }

        return redirect()->route('volunteer.tracking', $volunteer->volunteer_no);
    }

    /**
     * Printable Digital Photo ID Badge
     */
    public function idCard($volunteer_no)
    {
        $volunteer = Volunteer::with('tournament')->where('volunteer_no', $volunteer_no)->firstOrFail();
        return view('volunteer.id-card', compact('volunteer'));
    }
}

