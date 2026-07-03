<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FacturaExport implements FromArray, WithStyles, ShouldAutoSize
{
    protected $cita;

    public function __construct($cita)
    {
        $this->cita = $cita;
    }

    public function array(): array
{
    return [
        ['ODONTOLOGÍA DR. WILSON MONTENEGRO'],
        ['Factura de Atención Odontológica'],

        ['Factura N°', 'FAC-' . $this->cita->IDcita],
        ['Paciente', $this->cita->NombrePaciente],
        ['Correo', $this->cita->Email],
        ['Servicio', $this->cita->Servicio],
        ['Precio', '$ ' . number_format($this->cita->Precio, 0, ',', '.')],
        ['Fecha Entrada', $this->cita->Fecha_entrada],
        ['Estado', $this->cita->Estado],

        [
            'Observación',
            'Este documento certifica la programación y/o atención de la cita odontológica registrada en el sistema.'
        ]
    ];
}

    public function styles(Worksheet $sheet)
    {

        $sheet->mergeCells('A1:B1');
        $sheet->mergeCells('A2:B2');

        $sheet->mergeCells('A12:B12');
        $sheet->mergeCells('A13:B13');


        return [

            // TITULO
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


            // SUBTITULO
            2 => [

                'font' => [

                    'bold' => true,

                    'size' => 13

                ],

                'alignment' => [

                    'horizontal' =>
                    Alignment::HORIZONTAL_CENTER

                ]

            ],



            // ETIQUETAS
            'A4:A10' => [

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



            // OBSERVACION
            12 => [

                'font' => [

                    'bold' => true

                ]

            ],



            // BORDES
            'A4:B10' => [

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
