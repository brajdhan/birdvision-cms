<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaleExport implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (!empty($this->startDate) && !empty($this->endDate)) {
            return Sale::select('customers.name as customer_name', 'sales.product_name', 'sales.amount', 'sales.created_at')
                ->join('customers', 'sales.customer_id', '=', 'customers.id')
                ->whereDate('sales.created_at', '>=', $this->startDate)
                ->whereDate('sales.created_at', '<=', $this->endDate)
                ->get()
                ->map(function ($sale) {
                    $sale->formatted_date = $sale->created_at->format('Y-m-d H:i:s');
                    unset($sale->created_at);
                    return $sale;
                });
        }

        return Sale::select('customers.name as customer_name', 'sales.product_name', 'sales.amount', 'sales.created_at')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->get()
            ->map(function ($sale) {
                $sale->formatted_date = $sale->created_at->format('Y-m-d H:i:s');
                unset($sale->created_at);
                return $sale;
            });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['Customer Name', 'Product Name', 'Amount', 'Date'];
    }

    /**
     * Apply styles to the Excel sheet
     *
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
    }
}
