<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $totalCustomers = Customer::count();
        $totalSalesValue = Sale::sum('amount');

        // Check if both filters exist
        if (!empty($startDate) && !empty($endDate)) {
            
            $totalCustomers = Customer::whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->count();

            $totalSalesValue = Sale::whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->sum('amount');
        }

        $monthOrder = [
            'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6,
            'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12
        ];

        // Monthly sales trends (line chart) mysql
        $monthlySalesArr = Sale::selectRaw('DATE_FORMAT(created_at, "%b") as month, SUM(amount) as total_sales')
            ->groupByRaw('DATE_FORMAT(created_at, "%b")')
            ->orderByRaw('MIN(created_at)')
            ->get()->toArray();


        // Monthly sales trends (line chart) pgsql
        // $monthlySalesArr = Sale::selectRaw('TO_CHAR(created_at, \'Mon\') as month, SUM(amount) as total_sales')
        // ->groupByRaw('TO_CHAR(created_at, \'Mon\')')
        // ->orderByRaw('MIN(created_at)')
        // ->get()->toArray();

        usort($monthlySalesArr, function($a, $b) use ($monthOrder) {
            return $monthOrder[$a['month']] <=> $monthOrder[$b['month']];
        });
        $monthlySales = array_map(function($item) {
            return (object) $item;
        }, $monthlySalesArr);

        // Top 5 customers by sales value (bar chart)
        $topCustomers = Sale::selectRaw('customer_id, SUM(amount) as total_sales')
            ->groupBy('customer_id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->with('customer')
            ->get();

        return view('dashboard', compact('totalCustomers', 'totalSalesValue', 'monthlySales', 'topCustomers', 'startDate', 'endDate'));
    }
}
