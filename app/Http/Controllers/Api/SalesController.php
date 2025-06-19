<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    /**
     * Get all active sales
     */
    public function index()
    {
        Log::info('API Sales index called');
        
        try {
            $sales = Sale::where('is_active', true)
                ->select('id', 'name', 'whatsapp as phone', 'email', 'description')
                ->orderBy('name')
                ->get();
            
            Log::info('Sales data retrieved', ['count' => $sales->count()]);
            
            return response()->json($sales);
        } catch (\Exception $e) {
            Log::error('Error in sales API', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Get specific sales by ID
     */
    public function show($id)
    {
        try {
            $sale = Sale::where('is_active', true)
                ->select('id', 'name', 'whatsapp as phone', 'email', 'description')
                ->findOrFail($id);

            return response()->json($sale);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Sales not found'], 404);
        }
    }
}
