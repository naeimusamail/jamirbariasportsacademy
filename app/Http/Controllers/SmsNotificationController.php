<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\Batch;
use App\Models\Sport;
use App\Models\Payment;
use App\Models\SmsLog;
use Illuminate\Support\Facades\Auth;

class SmsNotificationController extends Controller
{
    /**
     * SMS Broadcast Portal Dashboard
     */
    public function index()
    {
        $currentMonth = 'অক্টোবর';
        $currentYear = date('Y');

        $activeTraineesCount = Trainee::where('status', 'active')->count();

        // Calculate Defaulters Count
        $paidTraineeIds = Payment::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('status', 'paid')
            ->where('fee_type', 'monthly')
            ->pluck('trainee_id');

        $defaultersCount = Trainee::where('status', 'active')
            ->whereNotIn('id', $paidTraineeIds)
            ->count();

        $batches = Batch::all();
        $sports = Sport::all()->unique('name');

        $smsLogs = SmsLog::with('sender')->latest()->paginate(15);
        $totalSentSms = SmsLog::sum('recipient_count');

        return view('admin.sms.index', compact(
            'activeTraineesCount',
            'defaultersCount',
            'batches',
            'sports',
            'smsLogs',
            'totalSentSms',
            'currentMonth',
            'currentYear'
        ));
    }

    /**
     * Send Bulk SMS Broadcast
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'recipient_group' => 'required|in:all,defaulters,batch,sport,custom',
            'batch_id' => 'nullable|exists:batches,id',
            'sport_id' => 'nullable|exists:sports,id',
            'custom_numbers' => 'nullable|string',
            'message' => 'required|string|min:3|max:500',
        ]);

        $currentMonth = 'অক্টোবর';
        $currentYear = date('Y');
        $phoneNumbers = [];

        switch ($validated['recipient_group']) {
            case 'all':
                $phoneNumbers = Trainee::where('status', 'active')->whereNotNull('phone')->pluck('phone')->toArray();
                break;

            case 'defaulters':
                $paidTraineeIds = Payment::where('month', $currentMonth)
                    ->where('year', $currentYear)
                    ->where('status', 'paid')
                    ->where('fee_type', 'monthly')
                    ->pluck('trainee_id');

                $phoneNumbers = Trainee::where('status', 'active')
                    ->whereNotIn('id', $paidTraineeIds)
                    ->whereNotNull('phone')
                    ->pluck('phone')
                    ->toArray();
                break;

            case 'batch':
                if ($request->filled('batch_id')) {
                    $phoneNumbers = Trainee::where('status', 'active')
                        ->where('batch_id', $request->batch_id)
                        ->whereNotNull('phone')
                        ->pluck('phone')
                        ->toArray();
                }
                break;

            case 'sport':
                if ($request->filled('sport_id')) {
                    $phoneNumbers = Trainee::where('status', 'active')
                        ->where('sport_id', $request->sport_id)
                        ->whereNotNull('phone')
                        ->pluck('phone')
                        ->toArray();
                }
                break;

            case 'custom':
                if ($request->filled('custom_numbers')) {
                    $raw = explode(',', $request->custom_numbers);
                    foreach ($raw as $num) {
                        $cleaned = trim($num);
                        if (!empty($cleaned)) {
                            $phoneNumbers[] = $cleaned;
                        }
                    }
                }
                break;
        }

        // Clean and unique phone numbers
        $uniqueNumbers = array_values(array_unique(array_filter($phoneNumbers)));
        $recipientCount = count($uniqueNumbers);

        if ($recipientCount === 0) {
            return back()->with('error', 'নির্বাচিত ক্যাটাগরিতে কোনো বৈধ ফোন নম্বর পাওয়া যায়নি!')->withInput();
        }

        // Calculate Bangla/Unicode SMS parts (70 chars per standard part)
        $charCount = mb_strlen($validated['message'], 'UTF-8');
        $smsParts = max(1, (int) ceil($charCount / 70));

        // Sample recipients for record (up to first 5)
        $sample = implode(', ', array_slice($uniqueNumbers, 0, 5));
        if ($recipientCount > 5) {
            $sample .= ' ... এবং আরো ' . ($recipientCount - 5) . ' জন';
        }

        // Log SMS Broadcast into database
        SmsLog::create([
            'recipient_group' => $validated['recipient_group'],
            'recipient_count' => $recipientCount,
            'sample_recipients' => $sample,
            'message' => $validated['message'],
            'sms_parts' => $smsParts,
            'gateway_status' => 'delivered', // simulated gateway active
            'sent_by_user_id' => Auth::id(),
        ]);

        return back()->with('success', "🎉 সফলভাবে {$recipientCount} জন প্রাপকের কাছে SMS ব্রডকাস্ট পাঠানো হয়েছে ({$smsParts} পার্টস SMS/জন)!");
    }
}

