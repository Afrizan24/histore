<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::where('is_active', true)->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $validated['is_active'] = true;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sales', 'public');
        }

        Sale::create($validated);

        return redirect()->route('sales.index')
            ->with('success', 'Sales representative added successfully.');
    }

    public function edit(Sale $sale)
    {
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($sale->image) {
                Storage::disk('public')->delete($sale->image);
            }
            $validated['image'] = $request->file('image')->store('sales', 'public');
        }

        $sale->update($validated);

        return redirect()->route('sales.index')
            ->with('success', 'Sales representative updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        if ($sale->image) {
            Storage::disk('public')->delete($sale->image);
        }
        
        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Sales representative deleted successfully.');
    }

    public function adminIndex()
    {
        $sales = \App\Models\Sale::orderByDesc('created_at')->paginate(20);
        return view('admin.sales.index', compact('sales'));
    }
} 