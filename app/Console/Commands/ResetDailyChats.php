<?php

namespace App\Console\Commands;

use App\Models\WhatsappChat;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ResetDailyChats extends Command
{
    protected $signature = 'sales:reset-chats {--date= : Reset chats for specific date (Y-m-d format)}';
    protected $description = 'Reset daily chat counts for all sales';

    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::today();
        
        $this->info("Resetting chat counts for date: " . $date->format('Y-m-d'));
        
        $deletedCount = WhatsappChat::whereDate('chatted_at', $date)->delete();
        
        $this->info("Deleted {$deletedCount} chat records for {$date->format('Y-m-d')}");
        
        return 0;
    }
} 