<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\CustomerCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CustomersExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // Retrieve all customer categories
        $categories = CustomerCategory::all();

        foreach ($categories as $category) {
            // For each category, get customers belonging to that category
            $customers = Customer::where('customer_category_id', $category->id)->get();

            // Create a sheet for each category
            $sheets[] = new CustomerSheet($category->name, $customers);
        }

        return $sheets;
    }
}
