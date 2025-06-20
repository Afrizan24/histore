<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'whatsapp',
        'email',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function whatsappChats()
    {
        return $this->hasMany(WhatsappChat::class);
    }

    public function getWhatsappUrlAttribute()
    {
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        return "https://wa.me/{$number}";
    }

    /**
     * Get today's chat count for this sale
     */
    public function getTodayChatCount()
    {
        return $this->whatsappChats()
            ->whereDate('chatted_at', Carbon::today())
            ->count();
    }

    /**
     * Check if this sale has reached daily limit
     */
    public function hasReachedDailyLimit($limit = 5)
    {
        return $this->getTodayChatCount() >= $limit;
    }

    /**
     * Get sales that are available for chat (not reached daily limit)
     */
    public static function getAvailableSales()
    {
        return self::where('is_active', true)
            ->where(function($query) {
                $query->whereDoesntHave('whatsappChats', function($q) {
                    $q->whereDate('chatted_at', Carbon::today());
                }, '>=', 5)
                ->orWhereHas('whatsappChats', function($q) {
                    $q->whereDate('chatted_at', Carbon::today());
                }, '<', 5);
            })
            ->get();
    }

    /**
     * Record a chat for this sale
     */
    public function recordChat($userId = null, $request = null)
    {
        return WhatsappChat::recordChat($this->id, $userId, $request);
    }
} 