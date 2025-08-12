<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tiket</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #e5e5e5;
        }
        h3 {
            margin: 0;
        }
    </style>
</head>
<body>
    <h3>Laporan Tiket</h3>
    <p>Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
    <p>Total Tiket: {{ $tasks->count() }} dari {{ $networkCount }} Jaringan</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Cluster</th>
                <th>Categori</th>
                <th>Bulan</th>
                <th>Case ID</th>
                <th>Nojar</th>
                <th>Pelanggan</th>
                <th>Tanggal Aduan</th>
                <th>Durasi</th>
                <th>Case Gangguan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $index => $task)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $task->customer?->cluster ?? '-' }}</td>
                    <td>{{ $task->category }}</td>
                    <td>{{ $task->created_at->translatedFormat('F') }}</td>
                    <td>{{ $task->task_number }}</td>
                    <td>{{ $task->customer?->network_number ?? '-' }}</td>
                    <td>{{ $task->customer?->name ?? '-' }}</td>
                    <td>{{ $task->created_at->translatedFormat('d F') }}</td>
                    <td>{{ $task->duration ?? '-' }}</td>
                    <td>{{ $task->detail ?? '-' }}</td>
                    <td>
                        @switch($task->action)
                            @case(null)
                                Belum Dimulai
                                @break
                            @case('completed')
                                Selesai
                                @break
                            @default
                                {{ $task->action }}
                        @endswitch
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br><br>
    <h4>Ringkasan Kinerja</h4>
    <table>
        <tr>
            <th style="width: 30%">Failure Rate (FR)</th>
            <td>{{ $fr }}%</td>
        </tr>
        <tr>
            <th>Service Level Agreement (SLA)</th>
            <td>{{ $sla }}%</td>
        </tr>
        <tr>
            <th>Mean Time to Repair (MTTR)</th>
            <td>{{ $mttr }} Jam</td>
        </tr>
    </table>
    <br><br><br><br>
    <table style="width: 100%; border: none">
        <tr>
            <td style="text-align: center; border: none">
                Mengetahui,<br>
                <strong>Supervisor</strong><br><br><br><br>
                ______________________
            </td>
            <td style="text-align: center; border: none">
                Dicetak oleh,<br>
                <strong>{{ auth()->user()->name ?? 'Sistem' }}</strong><br><br><br><br>
                ______________________
            </td>
        </tr>
    </table>
</body>
</html>
