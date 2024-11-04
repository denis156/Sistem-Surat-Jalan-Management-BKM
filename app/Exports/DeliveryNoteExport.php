<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DeliveryNoteExport implements FromView, ShouldAutoSize, WithStyles, WithProperties, WithColumnWidths, WithEvents
{
    // Konstanta warna font dan fill
    const TITLE_FONT_COLOR = 'FFFFFF';
    const TITLE_FILL_COLOR = '1E4129';
    const HEADER_FONT_COLOR = 'FFFFFF';
    const HEADER_FILL_COLOR = '1E4129';
    const HIGHLIGHT_FONT_COLOR = '8b0000';
    const HIGHLIGHT_FILL_COLOR = 'f0e19f';

    // Konstanta kolom dan baris khusus
    const COLUMN_SHIP_TO_SUMMARY = 'A';
    const ROW_SHIP_TO_SUMMARY = 'RINGKASAN GUDANG';
    const COLUMN_ITEM_SUMMARY = 'A';
    const ROW_ITEM_SUMMARY = 'RINGKASAN KONDISI BARANG';

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('report.xlsx.laporan-surat-jalan-xlsx', $this->data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                $sheet->freezePane('A3'); // Freeze panes pada header

                // Apply styles
                $this->applyTitleStyle($sheet, $lastColumn);
                $this->applyHeaderStyle($sheet, $lastColumn);
                $this->applyBorders($sheet, $lastColumn, $lastRow);
                $this->applySubHeaderAndHighlightStyles($sheet, $lastRow);
                $this->applySpecialHeaderStyles($sheet);
                $this->autoSizeColumns($sheet, $lastColumn);

                // Mengatur style untuk tabel ringkasan
                $shipToSummaryRow = $this->findRowByContent($sheet, self::ROW_SHIP_TO_SUMMARY);
                $itemSummaryRow = $this->findRowByContent($sheet, self::ROW_ITEM_SUMMARY);
                if ($shipToSummaryRow) {
                    $this->styleSummaryTable($sheet, $shipToSummaryRow, 4);
                }
                if ($itemSummaryRow) {
                    $this->styleSummaryTable($sheet, $itemSummaryRow, 10);
                }
            },
        ];
    }

    private function applyTitleStyle($sheet, $lastColumn)
    {
        $sheet->getStyle('A1:' . $lastColumn . '1')
            ->getFont()->setBold(true)->setSize(16)->getColor()->setRGB(self::TITLE_FONT_COLOR);
        $sheet->getStyle('A1:' . $lastColumn . '1')
            ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::TITLE_FILL_COLOR);
        $sheet->getStyle('A1:' . $lastColumn . '1')
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    private function applyHeaderStyle($sheet, $lastColumn)
    {
        $sheet->getStyle('A2:' . $lastColumn . '2')
            ->getFont()->setBold(true)->getColor()->setRGB(self::HEADER_FONT_COLOR);
        $sheet->getStyle('A2:' . $lastColumn . '2')
            ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::HEADER_FILL_COLOR);
        $sheet->getStyle('A2:' . $lastColumn . '2')
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    private function applyBorders($sheet, $lastColumn, $lastRow)
    {
        $sheet->getStyle('A1:' . $lastColumn . $lastRow)
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }

    private function applySubHeaderAndHighlightStyles($sheet, $lastRow)
    {
        $subHeaderStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => self::HEADER_FONT_COLOR]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::HEADER_FILL_COLOR]],
        ];

        $highlightStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => self::HIGHLIGHT_FONT_COLOR]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::HIGHLIGHT_FILL_COLOR]],
        ];

        foreach ($sheet->getRowIterator(4) as $row) {
            $cellValue = $sheet->getCell('A' . $row->getRowIndex())->getValue();
            $range = 'A' . $row->getRowIndex() . ':D' . $row->getRowIndex();
            if ($cellValue === 'Detail Item' || $cellValue === 'Nama Item') {
                $sheet->getStyle($range)->applyFromArray($subHeaderStyle);
            } elseif ($cellValue === 'TOTAL ITEM') {
                $sheet->getStyle('C' . $row->getRowIndex() . ':D' . $row->getRowIndex())->applyFromArray($highlightStyle);
            }
        }
    }

    private function applySpecialHeaderStyles($sheet)
    {
        $specialHeaders = [
            ['RINGKASAN GUDANG', 'D'],
            ['RINGKASAN KONDISI BARANG', 'J'],
        ];

        foreach ($specialHeaders as $header) {
            $coordinate = $this->findHeaderCoordinate($sheet, $header[0], $header[1]);
            if ($coordinate) {
                $sheet->getStyle($coordinate)
                    ->getFont()->setBold(true)->getColor()->setRGB(self::HEADER_FONT_COLOR);
                $sheet->getStyle($coordinate)
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::HEADER_FILL_COLOR);
                $sheet->getStyle($coordinate)
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }
    }

    private function findHeaderCoordinate($sheet, $header, $startColumn)
    {
        foreach ($sheet->getRowIterator() as $row) {
            $cellValue = $sheet->getCell($startColumn . $row->getRowIndex())->getValue();
            if ($cellValue == $header) {
                $endColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($startColumn) + 3
                );
                return $startColumn . $row->getRowIndex() . ':' . $endColumn . $row->getRowIndex();
            }
        }
        return null;
    }

    private function autoSizeColumns($sheet, $lastColumn)
    {
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    private function findRowByContent($sheet, $content)
    {
        foreach ($sheet->getRowIterator() as $row) {
            if ($sheet->getCell(self::COLUMN_SHIP_TO_SUMMARY . $row->getRowIndex())->getValue() == $content) {
                return $row->getRowIndex();
            }
        }
        return null;
    }

    private function styleSummaryTable($sheet, $startRow, $columnCount)
    {
        $endColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnCount);

        $sheet->getStyle(self::COLUMN_SHIP_TO_SUMMARY . $startRow . ':' . $endColumn . $startRow)
            ->getFont()->setBold(true)->setSize(14)->getColor()->setRGB(self::TITLE_FONT_COLOR);
        $sheet->getStyle(self::COLUMN_SHIP_TO_SUMMARY . $startRow . ':' . $endColumn . $startRow)
            ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::TITLE_FILL_COLOR);
        $sheet->getStyle(self::COLUMN_SHIP_TO_SUMMARY . $startRow . ':' . $endColumn . $startRow)
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle(self::COLUMN_SHIP_TO_SUMMARY . ($startRow + 1) . ':' . $endColumn . ($startRow + 1))
            ->getFont()->setBold(true)->getColor()->setRGB(self::HEADER_FONT_COLOR);
        $sheet->getStyle(self::COLUMN_SHIP_TO_SUMMARY . ($startRow + 1) . ':' . $endColumn . ($startRow + 1))
            ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::HEADER_FILL_COLOR);

        $sheet->getStyle(self::COLUMN_SHIP_TO_SUMMARY . $startRow . ':' . $endColumn . ($startRow + 2))
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $sheet->getStyle($endColumn . ($startRow + 2))
            ->getFont()->setBold(true)->getColor()->setRGB(self::HIGHLIGHT_FONT_COLOR);
        $sheet->getStyle($endColumn . ($startRow + 2))
            ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::HIGHLIGHT_FILL_COLOR);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'name' => 'Arial',
                    'size' => 11,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 20,
            'D' => 25,
            'E' => 15,
            'F' => 12,
            'G' => 20,
            'H' => 8,
            'I' => 12,
            'J' => 20,
            'K' => 20,
            'L' => 12,
            'M' => 25,
            'N' => 25,
            'O' => 25,
            'P' => 20,
            'Q' => 20,
        ];
    }

    public function properties(): array
    {
        return [
            'creator' => 'PT. Barraka Karya Mandiri',
            'lastModifiedBy' => 'System',
            'title' => 'Laporan Surat Jalan',
            'description' => 'Laporan Surat Jalan PT. Barraka Karya Mandiri',
            'subject' => 'Laporan Surat Jalan',
            'keywords' => 'laporan,surat jalan,delivery note',
            'category' => 'Laporan',
            'manager' => 'Admin',
            'company' => 'PT. Barraka Karya Mandiri',
        ];
    }
}
