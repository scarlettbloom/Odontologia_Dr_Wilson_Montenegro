<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class VentaExport implements FromArray, WithStyles, ShouldAutoSize
{
    protected $venta;

    public function __construct($venta)
    {
        $this->venta = $venta;
    }

    public function array(): array
    {
        return [

            ['FACTURA DE VENTA'],
            [],

            ['Factura N°', $this->venta->idventa],

            ['Producto',
                $this->venta->producto->nombre ?? 'Producto eliminado'
            ],

            ['Cantidad',
                $this->venta->cantidad
            ],

            ['Subtotal',
                '$ '.number_format($this->venta->subtotal,0,',','.')
            ],

            ['Descuento',
                '$ '.number_format($this->venta->descuento,0,',','.')
            ],

            ['Total',
                '$ '.number_format($this->venta->total,0,',','.')
            ],

            ['Fecha de compra',
                $this->venta->created_at->format('d/m/Y H:i')
            ],

        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->mergeCells('A1:B1');

        return [

            1 => [

                'font' => [

                    'bold' => true,
                    'size' => 18,
                    'color' => ['rgb' => 'FFFFFF']

                ],

                'fill' => [

                    'fillType' => Fill::FILL_SOLID,

                    'startColor' => [

                        'rgb' => '0D6EFD'

                    ]

                ],

                'alignment' => [

                    'horizontal' =>
                    Alignment::HORIZONTAL_CENTER

                ]

            ],


            'A3:A8' => [

                'font' => [

                    'bold' => true

                ],

                'fill' => [

                    'fillType' => Fill::FILL_SOLID,

                    'startColor' => [

                        'rgb' => 'D9EAF7'

                    ]

                ]

            ],

            'A3:B8' => [

                'borders' => [

                    'allBorders' => [

                        'borderStyle' =>
                        Border::BORDER_THIN

                    ]

                ]

            ]

        ];

    }

}
