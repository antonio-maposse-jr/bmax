<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $categoryName;
    protected $products;

    public function __construct($categoryName, $products)
    {
        $this->categoryName = $categoryName;
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products->map(function ($product) {
            return [
                'Name' => $product->name,
                'Description' => $product->description,
                'Price' => $product->price,
                'Unit' => $product->unit,
                'Subcategory' => optional($product->subcategory)->name,
            ];
        });
    }

    public function title(): string
    {
        return $this->categoryName;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Price',
            'Unit',
            'Subcategory',
        ];
    }
}
