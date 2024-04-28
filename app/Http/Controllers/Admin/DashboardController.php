<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Process;
use App\Models\Product;
use App\Models\ProductionTask;
use Carbon\Carbon;
use Illuminate\Routing\Controller;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DashboardController extends Controller
{
    public function index()
    {   
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $productionComplete = Process::where('status', 'complete')->count();
        $totalWorkTime = ProductionTask::sum('total_work_time');

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'Dashboard' => false,
            ],
            'page' => 'resources/views/admin/dashboard.blade.php',
            'controller' => 'app/Http/Controllers/Admin/DashboardController.php',
            'totalCustomerNr' => $totalCustomers,
            'totalProductNr' => $totalProducts,
            'productionComplete' => $productionComplete,
            'totalWorkTime' => $totalWorkTime,
            ],
        );
    }

    public function generateGraphs(){
        $currentMonth = Carbon::now()->format('m');
        $processes = Process::whereMonth('created_at', $currentMonth)->get();

        $data = $processes->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('d');
        })->map(function($item) {
            return [
                'date' => Carbon::parse($item[0]->created_at)->format('d'),
                'volume' => $item->count('id'),
                'value' => $item->sum('order_value')
            ];
        })->values();

        return response()->json($data);
    }

    public function processStatusChartData()
    {
        $statuses = Process::select('status')
            ->distinct()
            ->pluck('status')
            ->toArray();

        $data = [];
        foreach ($statuses as $status) {
            $count = Process::where('status', $status)->count();
            $data[] = [
                'status' => $status,
                'count' => $count
            ];
        }

        return response()->json($data);
    }
}
