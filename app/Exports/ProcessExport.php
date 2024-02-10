<?php

namespace App\Exports;

use App\Models\Process;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProcessExport implements FromCollection, WithHeadings
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
        return Process::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->with('customer', 'user') // Eager load the customer and user relationships
            ->get()
            ->map(function ($process) {
                return [
                    'ID' => $process->id,
                    'Customer Name' => optional($process->customer)->name,
                    'User Name' => optional($process->user)->name,
                    'Nr Sheets' => $process->nr_sheets,
                    'Nr Panels' => $process->nr_panels,
                    'Order Value' => $process->order_value,
                    'Estimated Process Time' => $process->estimated_process_time,
                    'Date Required' => $process->date_required,
                    'Priority Level' => $process->priority_level,
                    'Job Reference' => $process->job_reference,
                    'Order Confirmation' => $process->order_confirmation,
                    'Colors' => $process->colors,
                    'Status' => $process->status,
                    'Stage Name' => $process->stage_name,
                    'Job Layout' => $process->job_layout,
                    'Cutting List' => $process->cutting_list,
                    'Quote' => $process->quote,
                    'Confirmation Call Record' => $process->confirmation_call_record,
                    'Signed Confirmation' => $process->signed_confirmation,
                    'Custom Cutting List' => $process->custom_cutting_list,
                    'Other Document' => $process->other_document,
                    'Cutting' => $process->cutting,
                    'Edging' => $process->edging,
                    'CNC Machining' => $process->cnc_machining,
                    'Grooving' => $process->grooving,
                    'Hinge Boring' => $process->hinge_boring,
                    'Wrapping' => $process->wrapping,
                    'Sanding' => $process->sanding,
                    'Hardware' => $process->hardware,
                    'Created At' => $process->created_at,
                    'Updated At' => $process->updated_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'User Name',
            'Nr Sheets',
            'Nr Panels',
            'Order Value',
            'Estimated Process Time',
            'Date Required',
            'Priority Level',
            'Job Reference',
            'Order Confirmation',
            'Colors',
            'Status',
            'Stage Name',
            'Job Layout',
            'Cutting List',
            'Quote',
            'Confirmation Call Record',
            'Signed Confirmation',
            'Custom Cutting List',
            'Other Document',
            'Cutting',
            'Edging',
            'CNC Machining',
            'Grooving',
            'Hinge Boring',
            'Wrapping',
            'Sanding',
            'Hardware',
            'Created At',
            'Updated At',
        ];
    }
}
