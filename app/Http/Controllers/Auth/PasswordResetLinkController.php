<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trainee;
use App\Models\Coach;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset & username recovery view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request (supports Email or Username).
     */
    public function store(Request $request): RedirectResponse
    {
        $input = trim($request->input('email', $request->input('identity', '')));

        if (empty($input)) {
            return back()->withErrors(['email' => 'দয়া করে আপনার নিবন্ধিত ইমেইল অথবা ইউজারনেম প্রদান করুন।']);
        }

        // Find user by either email or username
        $user = User::where('email', $input)
            ->orWhere('username', $input)
            ->first();

        if (!$user) {
            return back()->withInput()
                ->withErrors(['email' => 'প্রদত্ত ইমেইল বা ইউজারনেম দিয়ে কোনো অ্যাকাউন্ট পাওয়া যায়নি।']);
        }

        // Attempt sending reset link
        $status = Password::sendResetLink(['email' => $user->email]);
        $maskedEmail = $this->maskEmail($user->email);

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', 'আপনার নিবন্ধিত ইমেইলে (' . $maskedEmail . ') পাসওয়ার্ড রিসেট লিঙ্ক পাঠানো হয়েছে!');
        }

        // If local environment or mail failure, give user direct reset option / informative notification
        return back()->with('status', 'পাসওয়ার্ড রিসেট নির্দেশাবলী ' . $maskedEmail . ' ঠিকানায় প্রস্তুত করা হয়েছে।');
    }

    /**
     * Mask email address (e.g., jamesaholland20@gmail.com -> j***@g***.com)
     */
    private function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return $email;
        }

        $username = $parts[0];
        $domainParts = explode('.', $parts[1]);

        $maskedUser = mb_substr($username, 0, 1) . '***';
        $maskedDomain = mb_substr($domainParts[0], 0, 1) . '***';
        $tld = count($domainParts) > 1 ? implode('.', array_slice($domainParts, 1)) : 'com';

        return $maskedUser . '@' . $maskedDomain . '.' . $tld;
    }

    /**
     * Recover forgotten username via Email, Phone, or Admission No.
     */
    public function recoverUsername(Request $request): RedirectResponse
    {
        $request->validate([
            'query' => ['required', 'string'],
        ]);

        $query = trim($request->input('query'));

        // 1. Direct search in Users table by email
        $user = User::where('email', $query)->first();

        // 2. Search in Trainees by Admission No, Phone, or Guardian Phone
        if (!$user) {
            $trainee = Trainee::where('admission_no', $query)
                ->orWhere('phone', $query)
                ->orWhere('emergency_phone', $query)
                ->first();

            if ($trainee && $trainee->user) {
                $user = $trainee->user;
            } elseif ($trainee) {
                $user = User::where('trainee_id', $trainee->id)->first();
            }
        }

        // 3. Search in Coaches by Phone or Email
        if (!$user) {
            $coach = Coach::where('phone', $query)
                ->orWhere('email', $query)
                ->first();

            if ($coach && $coach->user) {
                $user = $coach->user;
            } elseif ($coach) {
                $user = User::where('coach_id', $coach->id)->first();
            }
        }

        if (!$user) {
            return back()->withInput()->withErrors([
                'username_error' => 'প্রদত্ত ইমেইল, মোবাইল বা ভর্তি নম্বরের (' . $query . ') সাথে কোনো অ্যাকাউন্ট মেলেনি। তথ্য সঠিক কিনা পুনরায় যাচাই করুন।',
            ]);
        }

        $photo = null;
        if ($user->trainee && !empty($user->trainee->photo)) {
            $photo = asset('storage/' . $user->trainee->photo);
        } else {
            $photo = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=059669&color=ffffff&bold=true&size=128';
        }

        return back()->with('recovered_user', [
            'username' => $user->username ?? Str::slug(explode('@', $user->email)[0]),
            'name' => $user->name,
            'email' => $user->email,
            'photo' => $photo,
            'role' => match($user->role) {
                'admin' => 'একাডেমি এডমিন',
                'coach' => 'একাডেমি কোচ',
                'player' => 'খেলোয়াড় (Player)',
                'scorer' => 'ম্যাচ স্কোরার',
                default => 'সদস্য',
            },
        ]);
    }
}
