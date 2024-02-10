<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $categoryName;
    protected $customers;

    public function __construct($categoryName, $customers)
    {
        $this->categoryName = $categoryName;
        $this->customers = $customers;
    }

    public function collection()
    {
        return $this->customers->map(function ($customer) {
            return [
                'Name' => $customer->name,
                'ID Type' => $customer->id_type,
                'ID Number' => $customer->id_number,
                'Email' => $customer->email,
                'Phone' => $customer->phone,
                'Address' => $customer->address,
                'Tax Number' => $customer->tax_number,
                'Contact Person Name' => $customer->contact_person_name,
                'Contact Person Phone' => $customer->contact_person_phone,
                'Contact Person Email' => $customer->contact_person_email,
                'ID Document' => $customer->id_document,
                'Company Reg Document' => $customer->company_reg_document,
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
            'ID Type',
            'ID Number',
            'Email',
            'Phone',
            'Address',
            'Tax Number',
            'Contact Person Name',
            'Contact Person Phone',
            'Contact Person Email',
            'ID Document',
            'Company Reg Document',
        ];
    }
}
