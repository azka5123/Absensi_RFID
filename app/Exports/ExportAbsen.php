<?php

namespace App\Exports;

use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAbsen implements WithStyles, FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $line = 0;


    public function view(): View
    {
        $absen = Absen::latest()->with('rStudent')->get();
        $absen = $absen->filter(function ($item) {
            $now = Carbon::now();
            $jamMasuk = Carbon::parse($item->jam_masuk);

            return $now->subMonths(1)->month == $jamMasuk->month;
        });
        $this->line = count($absen);
        return view('absen.absen_excel', compact('absen'));
    }

    public function styles(Worksheet $sheet)
    {
        $baris = 3 + $this->line;
        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(7);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(17);
        $sheet->getColumnDimension('E')->setWidth(17);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(5);
        return [
            'A1:G2' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thick'
                    ]
                ],
                'font' => [
                    'size' => '12',
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center'
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => "79E0EE"],
                ],
            ],
            'A3:G3' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin'
                    ]
                ],
                'font' => [
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => 'left',
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => "98EECC"],
                ],

            ],
            'A4:G' . $baris => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin'
                    ]
                ],
                'alignment' => [
                    'horizontal' => 'left',
                ],

            ]

        ];
    }
}
