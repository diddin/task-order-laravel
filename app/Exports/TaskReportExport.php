<?php

namespace App\Exports;

use App\Models\Task;
use App\Models\NetworkCount;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TaskReportExport implements FromCollection, WithHeadings, WithEvents
{
    protected $fr;
    protected $sla;
    protected $mttr;
    protected $networkCount;
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;

        $monthKey = Carbon::parse($startDate)->format('Y-m');
        $this->networkCount = NetworkCount::where('month', $monthKey)->first()?->total ?? 1;

        $tasks = Task::whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->get();

        $totalTickets = $tasks->count();
        $totalDuration = $tasks->sum(function ($task) {
            return $task->duration_in_hours ?? 0;
        });

        $daysInMonth = Carbon::parse($startDate)->daysInMonth;
        $slaDenominator = $this->networkCount * 24 * $daysInMonth;

        $this->fr = round(($totalTickets * 100) / $this->networkCount, 2);
        $this->sla = round(($slaDenominator - $totalDuration) * 100 / $slaDenominator, 2);
        $this->mttr = $totalTickets > 0 ? round((($totalTickets - 2) * 100) / $totalTickets, 2) : 0;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Task::with('customer', 'creator')
            ->whereDate('created_at', '>=', $this->startDate)
            ->whereDate('created_at', '<=', $this->endDate)
            ->orderBy('created_at', 'desc')
            ->get()
            ->values() // reset keys for numbering
            ->map(function($task, $index) {
                return [
                    'No'             => $index + 1,
                    'Cluster'        => $task->customer?->cluster ?? '-',
                    'Categori'       => $task->category,
                    'Bulan'          => $task->created_at->translatedFormat('F'),
                    'Case ID'        => $task->task_number,
                    'Nojar'          => $task->customer?->network_number ?? '-',
                    'Pelanggan'      => $task->customer?->name ?? '-',
                    'Tanggal Aduan'  => $task->created_at->format('Y-m-d'),
                    'Durasi'         => $task->duration ?? '-',
                    'Case Gangguan'    => $task->detail,
                    'Status'         => $task->action ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Cluster',
            'Categori',
            'Bulan',
            'Case ID',
            'Nojar',
            'Pelanggan',
            'Tanggal Aduan',
            'Durasi',
            'Case Gangguan',
            'Status',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Baris terakhir dari data
                $lastRow = $event->sheet->getHighestRow();

                // Tambah 2 baris ke bawah untuk footer
                $footerStartRow = $lastRow + 3;

                // Isi di kolom B (bukan A)
                // $sheet->setCellValue("B{$footerStartRow}", 'Dicetak oleh: ' . (Auth::user()->name ?? 'Sistem'));
                // $sheet->setCellValue("B" . ($footerStartRow + 1), 'Tanggal Cetak: ' . now()->translatedFormat('d F Y'));

                $sheet->setCellValue("B{$footerStartRow}", 'Failure Rate (FR):');
                $sheet->setCellValue("C{$footerStartRow}", $this->fr . '%');

                $sheet->setCellValue("B" . ($footerStartRow + 1), 'Service Level Agreement (SLA):');
                $sheet->setCellValue("C" . ($footerStartRow + 1), $this->sla . '%');

                $sheet->setCellValue("B" . ($footerStartRow + 2), 'Mean Time to Repair (MTTR):');
                $sheet->setCellValue("C" . ($footerStartRow + 2), $this->mttr . '%');

                // Footer cetak
                $sheet->setCellValue("B" . ($footerStartRow + 4), 'Dicetak oleh: ' . (Auth::user()->name ?? 'Sistem'));
                $sheet->setCellValue("B" . ($footerStartRow + 5), 'Tanggal Cetak: ' . now()->translatedFormat('d F Y'));
            },
        ];
    }
}
