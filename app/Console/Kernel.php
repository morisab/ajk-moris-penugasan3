<?php

namespace App\Console;

use DateTime;
use App\Jobs\SendEmail;
use Illuminate\Support\Stringable;
use Illuminate\Console\Scheduling\Schedule;
use App\Infrastructure\Repository\SqlUserRepository;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use App\Infrastructure\Repository\SqlPeminjamanVolumeRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $userSql = new SqlUserRepository();
            $peminjamanSql = new SqlPeminjamanRepository();
            $peminjamanVolumeSql = new SqlPeminjamanVolumeRepository();
            $volumeSql = new SqlVolumeRepository();

            $peminjaman = $peminjamanSql->getAllPeminjaman("SUCCESS");
            foreach ($peminjaman as $p) {
                $interval = new DateTime($p->getPaidAt());
                $interval = $interval->diff(new DateTime());
                $user = $userSql->find($p->getUserId());
                if ($interval->days > 7) {
                    SendEmail::dispatch($user->getEmail()->toString(), $p->getId()->toString());
                    $p->setStatus("EXPIRED");
                    $peminjamanSql->persist($p);
                    $peminjamanVolumes = $peminjamanVolumeSql->getAllPeminjamanVolumeByPeminjamanId($p->getId());
                    foreach ($peminjamanVolumes as $peminjamanVolume) {
                        $volumeSql->incrementJumlahTersedia($peminjamanVolume->getId());
                    }
                }
            }
        })->everyFiveSeconds();

        $schedule->command('queue:work')->everySixHours();
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
