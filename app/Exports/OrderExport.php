<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    protected $data;

    /**
     * Write code on Method.
     *
     * @return response()
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Write code on Method.
     *
     * @return response()
     */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * Write code on Method.
     *
     * @return response()
     */
    public function headings(): array
    {
        return [
            'No',
            'Order Date',
            'Delivery Date',
            'Customer Name',
            'Product Name',
            'Variation',
            'Qty',
            'Price',
            'Order No',
            'Methode Payment',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 35,
            'C' => 20,
            'D' => 30,
            'E' => 50,
            'F' => 15,
            'G' => 5,
            'H' => 10,
            'I' => 10,
            'J' => 20,
        ];
    }

    public function styles(Worksheet $data)
    {
        $data->getStyle('G')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_LEFT);

        return [
            // Style the first row as bold text.
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }
}
