<?php
// File: app/Http/Controllers/Admin/SliderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order', 'asc')->get();
        return view('admin.sliders.index', compact('sliders')); 
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            // ==========================================================
            // == PERUBAHAN DI SINI: Dinaikkan ke 5MB (5120 KB) ==
            // ==========================================================
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', 
            'button_text' => 'nullable|string|max:50',     
            'button_link' => 'nullable|string|url',      
            'order' => 'required|integer',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_slider'), $filename); 
            $data['image'] = $filename;
        }

        $data['is_active'] = $request->has('is_active');

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            // ==========================================================
            // == PERUBAHAN DI SINI: Dinaikkan ke 5MB (5120 KB) ==
            // ==========================================================
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', 
            'button_text' => 'nullable|string|max:50',     
            'button_link' => 'nullable|string|url',      
            'order' => 'required|integer',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $oldImagePath = public_path('foto_slider/' . $slider->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto_slider'), $filename);
            $data['image'] = $filename;
        }

        $data['is_active'] = $request->has('is_active');

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        $imagePath = public_path('foto_slider/' . $slider->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil dihapus.');
    }
}