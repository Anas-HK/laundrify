<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Seller;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AnalyticsService
{
    /**
     * Get dashboard metrics for the specified date range.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    public function getDashboardMetrics(Carbon $startDate, Carbon $endDate)
    {
        $totalUsers = User::where('created_at', '<=', $endDate)->count();
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        
        $totalSellers = Seller::where('created_at', '<=', $endDate)->count();
        $newSellers = Seller::whereBetween('created_at', [$startDate, $endDate])->count();
        
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total_amount');
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        $orderStatusCounts = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        $userRetentionRate = $this->calculateUserRetentionRate($startDate, $endDate);
        $sellerRetentionRate = $this->calculateSellerRetentionRate($startDate, $endDate);
        
        // Daily active users
        $dailyActiveUsers = $this->calculateDailyActiveUsers($startDate, $endDate);
        
        // Daily revenue
        $dailyRevenue = $this->calculateDailyRevenue($startDate, $endDate);
        
        return [
            'totalUsers' => $totalUsers,
            'newUsers' => $newUsers,
            'totalSellers' => $totalSellers,
            'newSellers' => $newSellers,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'avgOrderValue' => $avgOrderValue,
            'orderStatusCounts' => $orderStatusCounts,
            'userRetentionRate' => $userRetentionRate,
            'sellerRetentionRate' => $sellerRetentionRate,
            'dailyActiveUsers' => $dailyActiveUsers,
            'dailyRevenue' => $dailyRevenue,
        ];
    }
    
    /**
     * Get user analytics for the specified date range.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    public function getUserAnalytics(Carbon $startDate, Carbon $endDate)
    {
        $totalUsers = User::where('created_at', '<=', $endDate)->count();
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $activeUsers = $this->getActiveUsers($startDate, $endDate);
        
        // User registrations by day
        $registrationsByDay = User::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
        
        // Users by city
        $usersByCity = User::whereBetween('created_at', [$startDate, $endDate])
            ->select('city', DB::raw('count(*) as count'))
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(10)
            ->get()
            ->pluck('count', 'city')
            ->toArray();
        
        // Order frequency per user
        $orderFrequency = $this->calculateOrderFrequencyPerUser($startDate, $endDate);
        
        // Average orders per user
        $avgOrdersPerUser = $activeUsers > 0 ? Order::whereBetween('created_at', [$startDate, $endDate])->count() / $activeUsers : 0;
        
        // Users with most orders
        $usersWithMostOrders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('users.id', 'users.name', 'users.email', DB::raw('count(*) as order_count'))
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('order_count')
            ->limit(10)
            ->get()
            ->toArray();
        
        return [
            'totalUsers' => $totalUsers,
            'newUsers' => $newUsers,
            'activeUsers' => $activeUsers,
            'registrationsByDay' => $registrationsByDay,
            'usersByCity' => $usersByCity,
            'orderFrequency' => $orderFrequency,
            'avgOrdersPerUser' => $avgOrdersPerUser,
            'usersWithMostOrders' => $usersWithMostOrders,
        ];
    }
    
    /**
     * Get financial analytics for the specified date range.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    public function getFinancialAnalytics(Carbon $startDate, Carbon $endDate)
    {
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Revenue by day
        $revenueByDay = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();
        
        // Orders by day
        $ordersByDay = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
        
        // Revenue by service category
        $revenueByCategory = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('services', 'order_items.service_id', '=', 'services.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('services.category', DB::raw('SUM(order_items.price * order_items.quantity) as total'))
            ->groupBy('services.category')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'category')
            ->toArray();
        
        // Top revenue generating services
        $topServices = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('services', 'order_items.service_id', '=', 'services.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('services.id', 'services.service_name', DB::raw('SUM(order_items.price * order_items.quantity) as total'))
            ->groupBy('services.id', 'services.service_name')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->toArray();
        
        return [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'avgOrderValue' => $avgOrderValue,
            'revenueByDay' => $revenueByDay,
            'ordersByDay' => $ordersByDay,
            'revenueByCategory' => $revenueByCategory,
            'topServices' => $topServices,
        ];
    }
    
    /**
     * Get service analytics for the specified date range.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    public function getServiceAnalytics(Carbon $startDate, Carbon $endDate)
    {
        $totalServices = Service::where('created_at', '<=', $endDate)->count();
        $newServices = Service::whereBetween('created_at', [$startDate, $endDate])->count();
        
        // Services by category
        $servicesByCategory = Service::whereBetween('created_at', [$startDate, $endDate])
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'category')
            ->toArray();
        
        // Most ordered services
        $mostOrderedServices = DB::table('order_items')
            ->join('services', 'order_items.service_id', '=', 'services.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('services.id', 'services.service_name', DB::raw('SUM(order_items.quantity) as total_ordered'))
            ->groupBy('services.id', 'services.service_name')
            ->orderByDesc('total_ordered')
            ->limit(10)
            ->get()
            ->toArray();
        
        // Average service price
        $avgServicePrice = Service::where('created_at', '<=', $endDate)->avg('service_price');
        
        // Service price distribution
        $servicePriceDistribution = $this->calculateServicePriceDistribution($endDate);
        
        return [
            'totalServices' => $totalServices,
            'newServices' => $newServices,
            'servicesByCategory' => $servicesByCategory,
            'mostOrderedServices' => $mostOrderedServices,
            'avgServicePrice' => $avgServicePrice,
            'servicePriceDistribution' => $servicePriceDistribution,
        ];
    }
    
    /**
     * Get seller analytics for the specified date range.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    public function getSellerAnalytics(Carbon $startDate, Carbon $endDate)
    {
        $totalSellers = Seller::where('created_at', '<=', $endDate)->count();
        $newSellers = Seller::whereBetween('created_at', [$startDate, $endDate])->count();
        $activeSellers = $this->getActiveSellers($startDate, $endDate);
        
        // Seller registrations by day
        $registrationsByDay = Seller::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
        
        // Sellers by city
        $sellersByCity = Seller::whereBetween('created_at', [$startDate, $endDate])
            ->select('city', DB::raw('count(*) as count'))
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(10)
            ->get()
            ->pluck('count', 'city')
            ->toArray();
        
        // Top performing sellers
        $topSellers = DB::table('orders')
            ->join('sellers', 'orders.seller_id', '=', 'sellers.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('sellers.id', 'sellers.name', 'sellers.email', DB::raw('SUM(orders.total_amount) as total_revenue'))
            ->groupBy('sellers.id', 'sellers.name', 'sellers.email')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get()
            ->toArray();
        
        // Sellers with most services
        $sellersWithMostServices = DB::table('sellers')
            ->join('services', 'sellers.id', '=', 'services.seller_id')
            ->where('services.created_at', '<=', $endDate)
            ->select('sellers.id', 'sellers.name', DB::raw('count(*) as service_count'))
            ->groupBy('sellers.id', 'sellers.name')
            ->orderByDesc('service_count')
            ->limit(10)
            ->get()
            ->toArray();
        
        return [
            'totalSellers' => $totalSellers,
            'newSellers' => $newSellers,
            'activeSellers' => $activeSellers,
            'registrationsByDay' => $registrationsByDay,
            'sellersByCity' => $sellersByCity,
            'topSellers' => $topSellers,
            'sellersWithMostServices' => $sellersWithMostServices,
        ];
    }
    
    /**
     * Calculate user retention rate.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return float
     */
    private function calculateUserRetentionRate(Carbon $startDate, Carbon $endDate)
    {
        // Get users who registered before the start date
        $existingUsers = User::where('created_at', '<', $startDate)->pluck('id')->toArray();
        
        if (count($existingUsers) === 0) {
            return 0;
        }
        
        // Count how many of these users placed orders during the period
        $activeUsers = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('user_id', $existingUsers)
            ->select('user_id')
            ->distinct()
            ->count();
        
        return count($existingUsers) > 0 ? ($activeUsers / count($existingUsers)) * 100 : 0;
    }
    
    /**
     * Calculate seller retention rate.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return float
     */
    private function calculateSellerRetentionRate(Carbon $startDate, Carbon $endDate)
    {
        // Get sellers who registered before the start date
        $existingSellers = Seller::where('created_at', '<', $startDate)->pluck('id')->toArray();
        
        if (count($existingSellers) === 0) {
            return 0;
        }
        
        // Count how many of these sellers received orders during the period
        $activeSellers = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('seller_id', $existingSellers)
            ->select('seller_id')
            ->distinct()
            ->count();
        
        return count($existingSellers) > 0 ? ($activeSellers / count($existingSellers)) * 100 : 0;
    }
    
    /**
     * Calculate daily active users.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    private function calculateDailyActiveUsers(Carbon $startDate, Carbon $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
    }
    
    /**
     * Calculate daily revenue.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    private function calculateDailyRevenue(Carbon $startDate, Carbon $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();
    }
    
    /**
     * Calculate order frequency per user.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    private function calculateOrderFrequencyPerUser(Carbon $startDate, Carbon $endDate)
    {
        $orderCounts = DB::table('orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('user_id', DB::raw('count(*) as order_count'))
            ->groupBy('user_id')
            ->get()
            ->pluck('order_count')
            ->toArray();
        
        $frequency = [
            '1' => 0,      // 1 order
            '2-3' => 0,    // 2-3 orders
            '4-5' => 0,    // 4-5 orders
            '6-10' => 0,   // 6-10 orders
            '10+' => 0,    // More than 10 orders
        ];
        
        foreach ($orderCounts as $count) {
            if ($count == 1) {
                $frequency['1']++;
            } elseif ($count >= 2 && $count <= 3) {
                $frequency['2-3']++;
            } elseif ($count >= 4 && $count <= 5) {
                $frequency['4-5']++;
            } elseif ($count >= 6 && $count <= 10) {
                $frequency['6-10']++;
            } else {
                $frequency['10+']++;
            }
        }
        
        return $frequency;
    }
    
    /**
     * Calculate service price distribution.
     *
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    private function calculateServicePriceDistribution(Carbon $endDate)
    {
        $prices = Service::where('created_at', '<=', $endDate)
            ->pluck('service_price')
            ->toArray();
        
        $distribution = [
            '0-500' => 0,
            '501-1000' => 0,
            '1001-2000' => 0,
            '2001-5000' => 0,
            '5000+' => 0,
        ];
        
        foreach ($prices as $price) {
            if ($price <= 500) {
                $distribution['0-500']++;
            } elseif ($price <= 1000) {
                $distribution['501-1000']++;
            } elseif ($price <= 2000) {
                $distribution['1001-2000']++;
            } elseif ($price <= 5000) {
                $distribution['2001-5000']++;
            } else {
                $distribution['5000+']++;
            }
        }
        
        return $distribution;
    }
    
    /**
     * Get active users for the specified date range.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return int
     */
    private function getActiveUsers(Carbon $startDate, Carbon $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->select('user_id')
            ->distinct()
            ->count();
    }
    
    /**
     * Get active sellers for the specified date range.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return int
     */
    private function getActiveSellers(Carbon $startDate, Carbon $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->select('seller_id')
            ->distinct()
            ->count();
    }
} 