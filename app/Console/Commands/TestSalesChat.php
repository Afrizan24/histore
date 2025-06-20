<?php

namespace App\Console\Commands;

use App\Models\Sale;
use App\Models\WhatsappChat;
use Illuminate\Console\Command;
use Carbon\Carbon;

class TestSalesChat extends Command
{
    protected $signature = 'sales:test-chat {sale_id} {count=1}';
    protected $description = 'Test sales chat system by adding fake chat records';

    public function handle()
    {
        $saleId = $this->argument('sale_id');
        $count = $this->argument('count');

        $sale = Sale::find($saleId);
        if (!$sale) {
            $this->error("Sales with ID {$saleId} not found!");
            return 1;
        }

        $this->info("Testing chat system for sales: {$sale->name}");
        $this->info("Current chat count today: " . $sale->getTodayChatCount());

        for ($i = 0; $i < $count; $i++) {
            WhatsappChat::create([
                'sale_id' => $saleId,
                'user_id' => null,
                'visitor_ip' => '127.0.0.1',
                'visitor_user_agent' => 'Test Command',
                'chatted_at' => now(),
            ]);
        }

        $this->info("Added {$count} chat(s)");
        $this->info("New chat count today: " . $sale->fresh()->getTodayChatCount());
        
        if ($sale->fresh()->hasReachedDailyLimit()) {
            $this->warn("Sales has reached daily limit!");
        }

        return 0;
    }
} 