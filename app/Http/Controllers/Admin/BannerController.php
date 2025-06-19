<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('order')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->order ?? Banner::max('order') + 1;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil dihapus.');
    }
}
