<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;

class AutoCompleteExpiredEvents extends Command
{
    protected $signature = 'event:maintenance-expired';
    protected $description = 'Mengubah status event yang telah melewati tanggal pelaksanaan menjadi selesai secara otomatis';

    public function handle()
    {
        $today = Carbon::today();

        $updatedCount = Event::where('is_delete', false)
            ->whereIn('status', ['disetujui', 'approved'])
            ->whereDate('tanggal_pelaksanaan', '<', $today)
            ->update(['status' => 'selesai']);

        $this->info("Maintenance sukses! Sebanyak {$updatedCount} event kadaluwarsa telah diubah statusnya menjadi selesai.");
    }
}