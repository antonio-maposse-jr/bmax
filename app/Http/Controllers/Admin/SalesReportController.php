<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

/**
 * Class SalesReportController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SalesReportController extends Controller
{
    public function index()
    {
        return view('admin.sales_report', [
            'title' => 'Sales Report',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'SalesReport' => false,
            ],
            'page' => 'resources/views/admin/sales_report.blade.php',
            'controller' => 'app/Http/Controllers/Admin/SalesReportController.php',
        ]);
    }
}
