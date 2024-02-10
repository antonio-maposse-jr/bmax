<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomersExport;
use App\Exports\ProcessExport;
use App\Exports\ProductsExport;
use App\Exports\UsersExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class RegularReportsController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RegularReportsController extends Controller
{
    public function index()
    {
        return view('admin.regular_reports', [
            'title' => 'Regular Reports',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'RegularReports' => false,
            ],
            'page' => 'resources/views/admin/regular_reports.blade.php',
            'controller' => 'app/Http/Controllers/Admin/RegularReportsController.php',
        ]);
    }

    public function reportsIndex(Request $request)
    {
        $reportType = $request->report_type;

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        switch ($reportType) {
            case "Users":
                return Excel::download(new UsersExport($startDate, $endDate), 'users.xlsx');
            case "Processes":
                return Excel::download(new ProcessExport($startDate, $endDate), 'process.xlsx');
            case "Products":
                return Excel::download(new ProductsExport($startDate, $endDate), 'products.xlsx');
            case "Customers":
                return Excel::download(new CustomersExport($startDate, $endDate), 'customers.xlsx');
            default:
                return "No report";
        }
    }
}
