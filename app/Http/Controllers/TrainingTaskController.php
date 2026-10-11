<?php

namespace App\Http\Controllers;

use App\Models\TrainingTask;
use App\Models\Trainee;
use App\Models\Batch;
use App\Models\Coach;
use Illuminate\Http\Request;

class TrainingTaskController extends Controller
{
    /**
     * Predefined Drill Library / Templates for 1-Click Assignment
     */
    public static function getDrillTemplates(): array
    {
        return [
            [
                'template_name' => '⚽ ফুটবল: কোন ড্রিবলিং ও ফার্স্ট-টাচ বল কন্ট্রোল',
                'title' => 'কোন ড্রিবলিং ও ফার্স্ট-টাচ বল কন্ট্রোল অনুশীলন',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'technical',
                'priority' => 'normal',
                'description' => '১০টি কোনের ভেতর দিয়ে বাম ও ডান উভয় পায়ে জিগ-জ্যাগ ড্রিবলিং করুন। দৈনিক ২০ মিনিট ড্রিবলিং ও বল কন্ট্রোল প্র্যাকটিস আবশ্যক।',
            ],
            [
                'template_name' => '⚽ ফুটবল: ১০০মি. এক্সিলারেশন ও স্প্রিন্ট টেস্ট ড্রিল',
                'title' => '১০০মি. এক্সিলারেশন ও স্প্রিন্ট টেস্ট ড্রিল',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'fitness',
                'priority' => 'high',
                'description' => 'ওয়ার্ম-আপের পর ৩ সেট ১০০ মিটার স্প্রিন্ট সর্বোচ্চ গতিতে সম্পন্ন করুন। প্রতিটি সেটের মাঝে ২ মিনিট সক্রিয় বিশ্রাম নিন।',
            ],
            [
                'template_name' => '⚽ ফুটবল: বক্সের বাইরে থেকে ডাইরেক্ট ফ্রি-কিক ও পেনাল্টি কার্লিং',
                'title' => 'বক্সের বাইরে থেকে ডাইরেক্ট ফ্রি-কিক ও পেনাল্টি কার্লিং টেকনিক',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'technical',
                'priority' => 'high',
                'description' => 'ডি-বক্সের বাইরে ২০ গজ দূর থেকে ওয়াল ম্যানিকুইনের উপর দিয়ে বলের ভেতরের অংশ দিয়ে ২০টি কার্লিং শট মারুন।',
            ],
            [
                'template_name' => '⚽ ফুটবল: হাই-প্রেসিং ও ট্যাকটিক্যাল ডিফেন্সিভ পজিশনিং',
                'title' => 'হাই-প্রেসিং ও ট্যাকটিক্যাল ডিফেন্সিভ পজিশনিং ড্রিল',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'tactical',
                'priority' => 'normal',
                'description' => 'ম্যাচ পরিস্থিতিতে উইং থেকে ক্রস আসলে সঠিক পজিশনিং নেওয়া এবং দ্রুত কাউন্টারে বল পাস দেওয়ার টেকটিক্যাল ড্রিল।',
            ],
            [
                'template_name' => '🏏 ক্রিকেট: নেট ব্যাটিংয়ে ফ্রন্ট-ফুট কভার ড্রাইভ অনুশীলন',
                'title' => 'নেট ব্যাটিংয়ে ফ্রন্ট-ফুট কভার ড্রাইভ ও শট সিলেকশন ড্রিল',
                'sport_type' => 'ক্রিকেট',
                'drill_category' => 'technical',
                'priority' => 'high',
                'description' => 'নেটে থ্রো-ডাউন এবং বোলিং মেশিনে ৫০টি ফুল-লেংথ বল ফেস করে নিখুঁত ফ্রন্ট-ফুট কভার ড্রাইভ ও ব্যালেন্স অনুশীলন।',
            ],
            [
                'template_name' => '🏏 ক্রিকেট: হাই ক্যাচিং ও ক্লোজ-ইন স্লিপ রিফ্লেক্স ক্যাচ',
                'title' => 'হাই ক্যাচিং ও ক্লোজ-ইন রিফ্লেক্স ফিল্ডিং প্র্যাকটিস',
                'sport_type' => 'ক্রিকেট',
                'drill_category' => 'technical',
                'priority' => 'normal',
                'description' => 'ক্যাচিং ব্যাটের সাহায্যে ৩০টি স্কাই ক্যাচ এবং স্লিপ কর্ডনে ২০টি রিফ্লেক্স ডাইভিং ক্যাচ অনুশীলন সম্পন্ন করুন।',
            ],
            [
                'template_name' => '🏏 ক্রিকেট: ডেথ ওভারে নিখুঁত ইয়র্কার ও ভ্যারিয়েশন ড্রিল',
                'title' => 'পাওয়ারপ্লেতে টাইট লাইন-লেংথ বলিং ও ইয়র্কার ড্রিল',
                'sport_type' => 'ক্রিকেট',
                'drill_category' => 'tactical',
                'priority' => 'high',
                'description' => 'স্টাম্পের গোড়ায় জুতার বাক্স রেখে ডেথ ওভারে লাগাতার ১২টি নিখুঁত ইয়র্কার ও ওয়াইড ইয়র্কার ডেলিভারি অনুশীলন।',
            ],
            [
                'template_name' => '🏃 অ্যাথলেটিক্স: ব্লক স্টার্ট ও ৫০মি. ইনিশিয়াল বার্স্ট স্প্রিন্ট',
                'title' => 'ব্লক স্টার্ট ও ৫০ মিটার ইনিশিয়াল বার্স্ট স্প্রিন্ট টেস্ট',
                'sport_type' => 'অ্যাথলেটিক্স',
                'drill_category' => 'fitness',
                'priority' => 'high',
                'description' => 'স্টার্টিং ব্লক থেকে লো ড্রাইভ অ্যাঙ্গেলে ৫ সেট ৫০ মিটার এক্সিলারেশন সম্পন্ন করুন। প্রতিটি সেটের টাইমিং নোট করুন।',
            ],
            [
                'template_name' => '🏸 ব্যাডমিন্টন: শাটলকক ফুটওয়ার্ক ড্রিল ও ড্রপ শট প্র্যাকটিস',
                'title' => 'শাটলকক ফুটওয়ার্ক ড্রিল ও ব্যাকহ্যান্ড ড্রপ শট প্র্যাকটিস',
                'sport_type' => 'ব্যাডমিন্টন',
                'drill_category' => 'technical',
                'priority' => 'normal',
                'description' => 'কোর্টের ৬টি কোণায় ৬-পয়েন্ট শাটল ফুটওয়ার্ক ড্রিল এবং নেটের সামনে ২০টি সূক্ষ্ম ব্যাকহ্যান্ড ড্রপ শট অনুকরণ।',
            ],
            [
                'template_name' => '⚡ সাধারণ ফিটনেস: কোর স্ট্যাবিলিটি ৩ মিনিট প্ল্যাঙ্ক ও বার্পি সার্কিট',
                'title' => 'কোর স্ট্যাবিলিটি: ৩ মিনিট এলবো প্ল্যাঙ্ক ও বার্পি সার্কিট',
                'sport_type' => 'সাধারণ ফিটনেস',
                'drill_category' => 'fitness',
                'priority' => 'normal',
                'description' => '৩ রাউন্ড: ১ মিনিট স্ট্যাটিক প্ল্যাঙ্ক + ১৫টি বার্পি + ২০টি মাউন্টেন ক্লাইম্বার্স। বিরতি ৩০ সেকেন্ড।',
            ],
            [
                'template_name' => '🧘 রিকভারি: ম্যাচ-পরবর্তী ডাইনামিক স্ট্রেচিং ও ফোম রোলিং',
                'title' => 'ম্যাচ-পরবর্তী ডাইনামিক স্ট্রেচিং ও ফোম রোলিং রিকভারি',
                'sport_type' => 'ফুটবল',
                'drill_category' => 'recovery',
                'priority' => 'low',
                'description' => 'ভারী প্র্যাকটিসের পর ২০ মিনিট ডাইনামিক হ্যামস্ট্রিং, কোয়াডস ও কাফ স্ট্রেচিং এবং ফোম রোলার দিয়ে পেশীর ক্লান্তি দূর করার সেশন।',
            ],
        ];
    }

    /**
     * Display listing of training tasks and drills.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = TrainingTask::with(['coach', 'batch', 'trainee']);

        if ($user->isPlayer()) {
            $traineeId = $user->trainee_id ?: (Trainee::first()->id ?? null);
            $trainee = Trainee::find($traineeId);
            $query->where(function($q) use ($traineeId, $trainee) {
                $q->where('trainee_id', $traineeId);
                if ($trainee && $trainee->batch_id) {
                    $q->orWhere('batch_id', $trainee->batch_id);
                }
            });
        } elseif ($user->isCoach()) {
            $coachId = $user->coach_id ?: (Coach::first()->id ?? null);
            if ($coachId) {
                $query->where('coach_id', $coachId);
            }
        }

        // Filtering
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('drill_category')) {
            $query->where('drill_category', $request->drill_category);
        }

        if ($request->filled('sport')) {
            $query->where('sport_type', 'LIKE', '%' . $request->sport . '%');
        }

        // Counts based on role scope
        $countsQuery = TrainingTask::query();
        if ($user->isPlayer()) {
            $traineeId = $user->trainee_id ?: (Trainee::first()->id ?? null);
            $trainee = Trainee::find($traineeId);
            $countsQuery->where(function($q) use ($traineeId, $trainee) {
                $q->where('trainee_id', $traineeId);
                if ($trainee && $trainee->batch_id) {
                    $q->orWhere('batch_id', $trainee->batch_id);
                }
            });
        } elseif ($user->isCoach()) {
            $coachId = $user->coach_id ?: (Coach::first()->id ?? null);
            if ($coachId) {
                $countsQuery->where('coach_id', $coachId);
            }
        }

        $totalCount = (clone $countsQuery)->count();
        $pendingCount = (clone $countsQuery)->where('status', 'pending')->count();
        $completedCount = (clone $countsQuery)->where('status', 'completed')->count();
        $reviewedCount = (clone $countsQuery)->where('status', 'reviewed')->count();

        $tasks = $query->latest('due_date')->paginate(12)->withQueryString();
        $batches = Batch::with('sport')->where('status', 'active')->get();
        $trainees = Trainee::with(['sport', 'batch'])->where('status', 'active')->orderBy('name')->get();
        $drillTemplates = self::getDrillTemplates();

        return view('tasks.index', compact(
            'tasks',
            'batches',
            'trainees',
            'totalCount',
            'pendingCount',
            'completedCount',
            'reviewedCount',
            'drillTemplates'
        ));
    }

    /**
     * Store new task/drill assigned by coach to players or batch.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $coachId = $user->coach_id ?: ($request->coach_id ?: (Coach::first()->id ?? 1));

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sport_type' => 'required|string|max:50',
            'drill_category' => 'required|in:fitness,tactical,technical,recovery',
            'due_date' => 'required|date',
            'priority' => 'required|in:high,normal,low',
            'batch_id' => 'nullable|exists:batches,id',
            'trainee_id' => 'nullable|exists:trainees,id',
        ]);

        $validated['coach_id'] = $coachId;
        $validated['status'] = 'pending';

        TrainingTask::create($validated);

        return back()->with('success', 'নতুন ট্রেনিং ড্রিল ও টাস্ক সফলভাবে প্লেয়ারদের জন্য নির্ধারণ করা হয়েছে!');
    }

    /**
     * Player marks task as completed with optional notes / reps.
     */
    public function complete(Request $request, TrainingTask $task)
    {
        $validated = $request->validate([
            'player_note' => 'nullable|string|max:500',
        ]);

        $note = $validated['player_note'] ?? 'ড্রিল সফলভাবে সম্পন্ন করা হয়েছে।';

        $task->update([
            'status' => 'completed',
            'player_note' => $note,
        ]);

        return back()->with('success', 'টাস্ক সম্পন্ন হিসেবে চিহ্নিত হয়েছে! কোচ শীঘ্রই ড্রিলটি মূল্যায়ন ও স্কোর প্রদান করবেন।');
    }

    /**
     * Quick Complete action for Coach / Admin (e.g. verified on the ground).
     */
    public function quickComplete(TrainingTask $task)
    {
        $user = auth()->user();
        $note = $task->player_note ?: 'মাঠে অনুশীলনের সময় প্রশিক্ষক কর্তৃক সরাসরি সম্পন্ন হিসেবে প্রত্যায়িত।';

        $task->update([
            'status' => 'completed',
            'player_note' => $note,
        ]);

        return back()->with('success', "ড্রিল '{$task->title}' সফলভাবে সম্পন্ন হিসেবে চিহ্নিত করা হয়েছে!");
    }

    /**
     * Coach reviews player task submission and awards score & feedback.
     */
    public function review(Request $request, TrainingTask $task)
    {
        $validated = $request->validate([
            'coach_score' => 'required|integer|min:1|max:10',
            'coach_feedback' => 'nullable|string|max:500',
        ]);

        $task->update([
            'status' => 'reviewed',
            'coach_score' => $validated['coach_score'],
            'coach_feedback' => $validated['coach_feedback'],
        ]);

        return back()->with('success', "প্লেয়ারের ড্রিল মূল্যায়ন সম্পন্ন হয়েছে! প্রদানকৃত স্কোর: {$validated['coach_score']}/১০ ★");
    }

    /**
     * Delete training task.
     */
    public function destroy(TrainingTask $task)
    {
        $task->delete();
        return back()->with('success', 'ট্রেনিং টাস্ক মুছে ফেলা হয়েছে!');
    }
}
