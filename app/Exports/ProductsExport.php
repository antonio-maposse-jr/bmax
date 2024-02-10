<?php
namespace App\Exports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // Retrieve all categories
        $categories = Category::all();

        foreach ($categories as $category) {
            // For each category, get products with the associated subcategory
            $products = Product::where('category_id', $category->id)
                ->with('subcategory')
                ->get();

            // Create a sheet for each category
            $sheets[] = new ProductSheet($category->name, $products);
        }

        return $sheets;
    }
}
