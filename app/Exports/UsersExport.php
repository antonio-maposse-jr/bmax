<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Query users within the specified date range
        return User::whereBetween('created_at', [$this->startDate, $this->endDate])
                    ->get(['id', 'name', 'email', 'created_at', 'updated_at']);
    }

    public function headings(): array
    {
        // Define column headings for the Excel file
        return [
            'ID',
            'Name',
            'Email',
            'Created At',
            'Updated At'
        ];
    }
}
