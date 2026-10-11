<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\Volunteer;
use App\Models\RegistrationCircular;

class ApplicationHubController extends Controller
{
    /**
     * Prepare all unified data for the central Application & Registration Hub
     */
    public static function getData(Request $request, string $defaultTab = 'admission'): array
    {
        $tab = $request->query('tab', $defaultTab);
        if (!in_array($tab, ['admission', 'local_player', 'volunteer'])) {
            if ($tab === 'local-player' || $tab === 'player') {
                $tab = 'local_player';
            } else {
                $tab = $defaultTab;
            }
        }

        // Circulars
        $admissionCircular = $request->filled('circular_id')
            ? RegistrationCircular::find($request->circular_id)
            : RegistrationCircular::ofType('admission');

        $localPlayerCircular = RegistrationCircular::ofType('local_player');
        $volunteerCircular = RegistrationCircular::ofType('volunteer');

        // Sports & Teams
        $sports = Sport::all()->unique('name');
        $teams = Team::where('status', 'active')->orderBy('name')->get();

        // Volunteer options
        $tournaments = Tournament::latest()->get();
        $departments = Volunteer::departments();
        $tshirtSizes = Volunteer::tshirtSizes();

        return [
            'tab' => $tab,
            'admissionCircular' => $admissionCircular,
            'localPlayerCircular' => $localPlayerCircular,
            'volunteerCircular' => $volunteerCircular,
            'circular' => match ($tab) {
                'volunteer' => $volunteerCircular,
                'local_player' => $localPlayerCircular,
                default => $admissionCircular,
            },
            'sports' => $sports,
            'teams' => $teams,
            'tournaments' => $tournaments,
            'departments' => $departments,
            'tshirtSizes' => $tshirtSizes,
        ];
    }

    /**
     * Display the Central Public Application Portal
     */
    public function index(Request $request)
    {
        $data = self::getData($request, 'admission');
        return view('apply.index', $data);
    }
}

