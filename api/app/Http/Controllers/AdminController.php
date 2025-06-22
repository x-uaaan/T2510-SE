<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Forum;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with stats.
     */
    public function dashboard()
    {
        $stats = [
            'events' => Event::count(),
            'forums' => Forum::count(),
            'posts' => Post::count(),
            'users' => User::count(),
        ];

        // Real data for the chart - last 6 months
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subMonths(5)->startOfMonth(); // 6 months including current
        $labels = [];
        $newSignups = [];
        $activeUsers = [];

        $usersByMonth = User::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as signups'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy('month');

        $cumulativeUsers = User::where('created_at', '<', $startDate)->count();

        for ($date = $startDate->copy(); $date->lessThanOrEqualTo($endDate); $date->addMonth()) {
            $monthKey = $date->format('Y-m');
            $labels[] = $date->format('F Y');

            $monthlySignups = $usersByMonth->get($monthKey)->signups ?? 0;
            $newSignups[] = $monthlySignups;

            $cumulativeUsers += $monthlySignups;
            $activeUsers[] = $cumulativeUsers;
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'New Sign-ups',
                    'data' => $newSignups,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Active Users',
                    'data' => $activeUsers,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                    'tension' => 0.4,
                ]
            ]
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'chartData' => $chartData
        ]);
    }
}
