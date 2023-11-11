<?php

namespace App\Console;

use App\Exports\ExportAbsen;
use App\Models\Absen;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $now = Carbon::now();
            if (!$now->isSunday() && $now->hour >= 11) {
                // $students = Student::all();
                $today = \Carbon\Carbon::today();
                $students = Student::whereNotIn('id', function ($query) use ($today) {
                    $query->select('student_id')
                        ->from('absens')
                        ->whereDate('jam_masuk', $today);
                })->get();

                foreach ($students as $student) {
                    if ($student->alfa < 3) {
                        $student->alfa += 1;
                        $student->save();
                    }
                    $absen = new Absen();
                    $absen->student_id = $student->id;
                    $absen->jam_masuk = $now;
                    $absen->keterangan = "Alfa";
                    $absen->save();
                }
            }

            if ($now->day == 1) {
                setlocale(LC_TIME, 'id_ID.utf8');
                $bulan = $now->copy()->subMonths(1)->isoFormat('MMMM');
                $tahun = $now->copy()->subMonths(1)->format('Y');
                $exportAbsen = new ExportAbsen();

                // Use store method to save the Excel file to the public directory
                $path = 'exports/excel/rekap absensi ' . $bulan . ' ' . $tahun . '.xlsx';
                Excel::store($exportAbsen, $path, 'public');

                // Return a response or perform actions according to your application's needs
                return response()->json(['message' => 'File successfully generated and available at ' . asset($path)]);
            }
        });
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
