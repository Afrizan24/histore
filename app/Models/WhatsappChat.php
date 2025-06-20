<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class WhatsappChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'user_id',
        'visitor_ip',
        'visitor_user_agent',
        'chatted_at'
    ];

    protected $casts = [
        'chatted_at' => 'datetime',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get chat count for a sale on a specific date
     */
    public static function getChatCountForSale($saleId, $date = null)
    {
        $date = $date ?? Carbon::today();
        return self::where('sale_id', $saleId)
            ->whereDate('chatted_at', $date)
            ->count();
    }

    /**
     * Check if a sale has reached daily chat limit
     */
    public static function hasReachedDailyLimit($saleId, $limit = 5, $date = null)
    {
        return self::getChatCountForSale($saleId, $date) >= $limit;
    }

    /**
     * Record a new chat
     */
    public static function recordChat($saleId, $userId = null, $request = null)
    {
        return self::create([
            'sale_id' => $saleId,
            'user_id' => $userId,
            'visitor_ip' => $request ? $request->ip() : null,
            'visitor_user_agent' => $request ? $request->userAgent() : null,
            'chatted_at' => now(),
        ]);
    }
} 