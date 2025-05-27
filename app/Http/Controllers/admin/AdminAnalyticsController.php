<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Seller;
use App\Models\Service;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Check if the user has admin access.
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    private function checkAdminAccess()
    {
        if (!Auth::check() || Auth::user()->sellerType != 1) {
            return redirect('/')->with('error', 'You do not have admin access.');
        }
        
        return null;
    }

    /**
     * Display the main analytics dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Get date range from request or default to last 30 days
        $dateRange = $request->get('date_range', '30days');
        
        // Get start and end dates based on selected range
        $dates = $this->getDateRange($dateRange);
        $startDate = $dates['start'];
        $endDate = $dates['end'];
        
        // Fetch dashboard metrics with caching (10 minutes)
        $dashboardMetrics = Cache::remember("analytics_dashboard_{$dateRange}", 600, function () use ($startDate, $endDate) {
            return $this->analyticsService->getDashboardMetrics($startDate, $endDate);
        });
        
        // Get metrics for comparison with previous period
        $previousDates = $this->getPreviousPeriod($startDate, $endDate);
        $previousMetrics = $this->analyticsService->getDashboardMetrics($previousDates['start'], $previousDates['end']);
        
        return view('admin.analytics.index', [
            'metrics' => $dashboardMetrics,
            'previousMetrics' => $previousMetrics,
            'dateRange' => $dateRange,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ]);
    }

    /**
     * Display user analytics.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function users(Request $request)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Get date range from request or default to last 30 days
        $dateRange = $request->get('date_range', '30days');
        
        // Get start and end dates based on selected range
        $dates = $this->getDateRange($dateRange);
        $startDate = $dates['start'];
        $endDate = $dates['end'];
        
        // Fetch user analytics with caching (15 minutes)
        $userAnalytics = Cache::remember("analytics_users_{$dateRange}", 900, function () use ($startDate, $endDate) {
            return $this->analyticsService->getUserAnalytics($startDate, $endDate);
        });
        
        return view('admin.analytics.users', [
            'analytics' => $userAnalytics,
            'dateRange' => $dateRange,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ]);
    }

    /**
     * Display financial analytics.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function financial(Request $request)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Get date range from request or default to last 30 days
        $dateRange = $request->get('date_range', '30days');
        
        // Get start and end dates based on selected range
        $dates = $this->getDateRange($dateRange);
        $startDate = $dates['start'];
        $endDate = $dates['end'];
        
        // Fetch financial analytics with caching (15 minutes)
        $financialAnalytics = Cache::remember("analytics_financial_{$dateRange}", 900, function () use ($startDate, $endDate) {
            return $this->analyticsService->getFinancialAnalytics($startDate, $endDate);
        });
        
        return view('admin.analytics.financial', [
            'analytics' => $financialAnalytics,
            'dateRange' => $dateRange,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ]);
    }

    /**
     * Display service analytics.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function services(Request $request)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Get date range from request or default to last 30 days
        $dateRange = $request->get('date_range', '30days');
        
        // Get start and end dates based on selected range
        $dates = $this->getDateRange($dateRange);
        $startDate = $dates['start'];
        $endDate = $dates['end'];
        
        // Fetch service analytics with caching (15 minutes)
        $serviceAnalytics = Cache::remember("analytics_services_{$dateRange}", 900, function () use ($startDate, $endDate) {
            return $this->analyticsService->getServiceAnalytics($startDate, $endDate);
        });
        
        return view('admin.analytics.services', [
            'analytics' => $serviceAnalytics,
            'dateRange' => $dateRange,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ]);
    }

    /**
     * Display seller analytics.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function sellers(Request $request)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Get date range from request or default to last 30 days
        $dateRange = $request->get('date_range', '30days');
        
        // Get start and end dates based on selected range
        $dates = $this->getDateRange($dateRange);
        $startDate = $dates['start'];
        $endDate = $dates['end'];
        
        // Fetch seller analytics with caching (15 minutes)
        $sellerAnalytics = Cache::remember("analytics_sellers_{$dateRange}", 900, function () use ($startDate, $endDate) {
            return $this->analyticsService->getSellerAnalytics($startDate, $endDate);
        });
        
        return view('admin.analytics.sellers', [
            'analytics' => $sellerAnalytics,
            'dateRange' => $dateRange,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ]);
    }

    /**
     * Get start and end dates based on selected range.
     *
     * @param  string  $range
     * @return array
     */
    private function getDateRange($range)
    {
        $end = Carbon::now();
        
        switch ($range) {
            case '7days':
                $start = Carbon::now()->subDays(7);
                break;
            case '30days':
                $start = Carbon::now()->subDays(30);
                break;
            case '90days':
                $start = Carbon::now()->subDays(90);
                break;
            case 'month':
                $start = Carbon::now()->startOfMonth();
                break;
            case 'quarter':
                $start = Carbon::now()->startOfQuarter();
                break;
            case 'year':
                $start = Carbon::now()->startOfYear();
                break;
            case 'all':
                $start = Carbon::now()->subYears(10); // Arbitrary long time ago
                break;
            default:
                $start = Carbon::now()->subDays(30);
        }
        
        return [
            'start' => $start->startOfDay(),
            'end' => $end->endOfDay(),
        ];
    }

    /**
     * Get the previous period for comparison.
     *
     * @param  \Carbon\Carbon  $start
     * @param  \Carbon\Carbon  $end
     * @return array
     */
    private function getPreviousPeriod($start, $end)
    {
        $days = $end->diffInDays($start) + 1;
        
        return [
            'start' => (clone $start)->subDays($days),
            'end' => (clone $end)->subDays($days),
        ];
    }
} 