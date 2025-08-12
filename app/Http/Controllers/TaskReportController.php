<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\NetworkCount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Exports\TaskReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
//use PDF; // DomPDF facade alias di config/app.php jika sudah install

class TaskReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter tanggal dari request, atau default dari awal bulan sampai hari ini
        $startDate = $request->input('start_date') ?? now()->startOfMonth()->toDateString();
        $endDate   = $request->input('end_date');// ?? now()->toDateString();

        if (empty($endDate)) {
            $startCarbon = \Carbon\Carbon::parse($startDate);
            $now = now();

            if ($startCarbon->isSameMonth($now)) {
                // Kalau startDate di bulan sekarang, endDate = hari ini
                $endDate = $now->toDateString();
            } else {
                // Kalau bukan bulan sekarang, endDate = tanggal terakhir bulan startDate
                $endDate = $startCarbon->endOfMonth()->toDateString();
            }
        }

        // Ambil data task berdasarkan rentang tanggal
        $tasks = Task::with(['customer', 'creator'])
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->orderBy('created_at', 'desc')
                    ->get();
                    //->paginate(10);
        //echo "<pre>"; print_r($tasks->toArray()); echo "</pre>"; die(); // Debugging output

        $monthKey = Carbon::parse($startDate)->format('Y-m');
        $networkCount = NetworkCount::where('month', $monthKey)->first()?->total ?? 1; // Avoid division by zero

        $totalTickets = $tasks->count();
        $totalDurationInHours = $tasks->sum(function ($task) {
            return $task->duration_in_hours ?? 0;
        });

        // FR
        $fr = round(($totalTickets * 100) / $networkCount, 2);

        // SLA
        $daysInMonth = Carbon::parse($startDate)->daysInMonth;
        $slaDenominator = $networkCount * 24 * $daysInMonth;
        $sla = round(($slaDenominator - $totalDurationInHours) * 100 / $slaDenominator, 2);

        // MTTR
        $interruptedCount = $totalTickets;
        $mttr = $interruptedCount > 0 ? round((($interruptedCount - 2) * 100) / $interruptedCount, 2) : 0;

        return view('reports.task', compact('tasks', 'startDate', 'endDate', 'fr', 'sla', 'mttr', 'networkCount'));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date') ?? now()->startOfMonth()->toDateString();
        $endDate = $request->input('end_date');// ?? now()->toDateString();
        $format = $request->input('format', 'excel');

        if (empty($endDate)) {
            $startCarbon = \Carbon\Carbon::parse($startDate);
            $now = now();

            if ($startCarbon->isSameMonth($now)) {
                // Kalau startDate di bulan sekarang, endDate = hari ini
                $endDate = $now->toDateString();
            } else {
                // Kalau bukan bulan sekarang, endDate = tanggal terakhir bulan startDate
                $endDate = $startCarbon->endOfMonth()->toDateString();
            }
        }

        if ($format === 'excel') {
            return Excel::download(new TaskReportExport($startDate, $endDate), "task_report_{$startDate}_to_{$endDate}.xlsx");
        }

        if ($format === 'pdf') {
            $tasks = Task::with(['customer', 'creator'])
                        ->whereDate('created_at', '>=', $startDate)
                        ->whereDate('created_at', '<=', $endDate)
                        ->orderBy('created_at', 'desc')
                        ->get();

            
            $monthKey = Carbon::parse($startDate)->format('Y-m');
            $networkCount = NetworkCount::where('month', $monthKey)->first()?->total ?? 1; // Avoid division by zero

            $totalTickets = $tasks->count();
            $totalDurationInHours = $tasks->sum(function ($task) {
                return $task->duration_in_hours ?? 0;
            });

            // FR
            $fr = round(($totalTickets * 100) / $networkCount, 2);

            // SLA
            $daysInMonth = Carbon::parse($startDate)->daysInMonth;
            $slaDenominator = $networkCount * 24 * $daysInMonth;
            $sla = round(($slaDenominator - $totalDurationInHours) * 100 / $slaDenominator, 2);

            // MTTR
            $interruptedCount = $totalTickets;
            $mttr = $interruptedCount > 0 ? round((($interruptedCount - 2) * 100) / $interruptedCount, 2) : 0;

            $pdf = PDF::loadView('reports.task_pdf', compact('tasks', 'startDate', 'endDate', 'fr', 'sla', 'mttr', 'networkCount'))
                        ->setPaper('A4', 'landscape');
            return $pdf->download("task_report_{$startDate}_to_{$endDate}.pdf");
        }

        abort(400, 'Format tidak didukung');
    }
}
