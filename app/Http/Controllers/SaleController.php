<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\WhatsappChat;
use App\Models\User;
use App\Notifications\SalesLimitReached;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        // Hanya tampilkan sales yang aktif dan belum mencapai batas chat harian
        $sales = Sale::getAvailableSales();
        return view('sales.index', compact('sales'));
    }

    public function chat(Request $request, Sale $sale)
    {
        // Cek apakah request dari detail produk (ada product_id)
        if ($request->filled('product_id')) {
            // Cek apakah sales masih tersedia untuk chat
            if ($sale->hasReachedDailyLimit()) {
                return redirect()->route('sales.index')
                    ->with('error', 'Sales ini telah mencapai batas chat harian. Silakan coba lagi besok.');
            }

            // Record the chat
            $sale->recordChat(
                auth()->id(), // null jika user tidak login
                $request
            );

            // Cek apakah ini adalah chat ke-5 (yang membuat sales mencapai limit)
            if ($sale->getTodayChatCount() >= 5) {
                // Notify admin
                $this->notifyAdminAboutLimitReached($sale);
            }
        }
        // Redirect ke WhatsApp dengan pesan jika ada
        $waUrl = $sale->whatsapp_url;
        if ($request->filled('message')) {
            $waUrl .= '?text=' . urlencode($request->input('message'));
        }
        return redirect($waUrl);
    }

    public function create()
    {
        return view('admin.sales.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sales', 'public');
        }

        Sale::create($validated);

        return redirect()->route('admin.sales.index')
            ->with('success', 'Sales representative added successfully.');
    }

    public function edit(Sale $sale)
    {
        return view('admin.sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($sale->image) {
                Storage::disk('public')->delete($sale->image);
            }
            $validated['image'] = $request->file('image')->store('sales', 'public');
        }

        $sale->update($validated);

        return redirect()->route('admin.sales.index')
            ->with('success', 'Sales representative updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        if ($sale->image) {
            Storage::disk('public')->delete($sale->image);
        }
        
        $sale->delete();

        return redirect()->route('admin.sales.index')
            ->with('success', 'Sales representative deleted successfully.');
    }

    public function adminIndex()
    {
        $sales = Sale::withCount(['whatsappChats' => function($query) {
            $query->whereDate('chatted_at', Carbon::today());
        }])->orderByDesc('created_at')->paginate(20);
        
        return view('admin.sales.index', compact('sales'));
    }

    public function adminCreate()
    {
        return view('admin.sales.create');
    }

    public function adminEdit(Sale $sale)
    {
        return view('admin.sales.edit', compact('sale'));
    }

    public function toggleActive(Sale $sale)
    {
        $sale->update(['is_active' => !$sale->is_active]);
        
        $status = $sale->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.sales.index')
            ->with('success', "Sales representative {$status} successfully.");
    }

    public function resetDailyChats(Sale $sale)
    {
        // Reset chat count untuk hari ini (untuk testing atau emergency)
        $sale->whatsappChats()
            ->whereDate('chatted_at', Carbon::today())
            ->delete();
            
        return redirect()->route('admin.sales.index')
            ->with('success', 'Daily chat count reset successfully.');
    }

    private function notifyAdminAboutLimitReached(Sale $sale)
    {
        // Log the event
        \Log::info("Sales {$sale->name} has reached daily chat limit of 5 chats.");
        
        // Send notification to all admin users
        $adminUsers = User::where('is_admin', true)->get();
        
        foreach ($adminUsers as $admin) {
            $admin->notify(new SalesLimitReached($sale));
        }
    }
} 