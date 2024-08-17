<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProkerController extends Controller
{
    public function index()
    {
        $prokers = Proker::all();
        return view('pages.dashboard.admin.proker.index', compact('prokers'));
    }

    public function create()
    {
        return view('pages.dashboard.admin.proker.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'divisi' => 'required|in:pendidikan,litbang,kominfo,rsdm',
            'title' => 'required|string',
            'content' => 'required|string',
            'fotokegiatan.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fotokegiatan = [];

        if ($request->hasFile('fotokegiatan')) {
            foreach ($request->file('fotokegiatan') as $file) {
                $filename = $file->getClientOriginalName(); // Preserve original filename
                $file->move(public_path('assets/divisi/kegiatan-divisi'), $filename);
                $fotokegiatan[] = $filename;
            }
        }

        Proker::create([
            'divisi' => $request->input('divisi'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'fotokegiatan' => implode(',', $fotokegiatan),
        ]);

        return redirect()->route('proker.index')->with('success', 'Proker created successfully.');
    }

    public function edit(Proker $proker)
    {
        $css = asset('assets/css/proker-edit.css');
        return view('pages.dashboard.admin.proker.edit', compact('proker', 'css'));
    }

    public function update(Request $request, Proker $proker)
    {
        $request->validate([
            'divisi' => 'required|in:pendidikan,litbang,kominfo,rsdm',
            'title' => 'required|string',
            'content' => 'required|string',
            'fotokegiatan.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Get existing images
        $existingImages = explode(',', $proker->fotokegiatan);

        // Handle file uploads
        if ($request->hasFile('fotokegiatan')) {
            foreach ($request->file('fotokegiatan') as $file) {
                $filename = $file->getClientOriginalName(); // Preserve original filename
                $file->move(public_path('assets/divisi/kegiatan-divisi'), $filename);
                $existingImages[] = $filename; // Add new image to existing list
            }
        }

        // Handle deletion of selected images
        if ($request->has('delete_images')) {
            $deleteImages = $request->input('delete_images');
            foreach ($deleteImages as $image) {
                if (in_array($image, $existingImages)) {
                    // Remove image from the storage
                    $filePath = public_path('assets/divisi/kegiatan-divisi/' . $image);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // Remove image from the database field
                    $existingImages = array_filter($existingImages, function ($existingImage) use ($image) {
                        return $existingImage !== $image;
                    });
                }
            }
        }

        // Update the database record
        $proker->update([
            'divisi' => $request->input('divisi'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'fotokegiatan' => implode(',', $existingImages),
        ]);

        return redirect()->route('proker.index')->with('success', 'Proker updated successfully.');
    }

    public function destroy($id)
    {
        $proker = Proker::findOrFail($id);

        // Remove all associated images
        $fotokegiatan = explode(',', $proker->fotokegiatan);
        foreach ($fotokegiatan as $file) {
            $filePath = public_path('assets/divisi/kegiatan-divisi/' . $file);
            if (file_exists($filePath)) {
                unlink($filePath); // Delete file
            }
        }

        $proker->delete(); // Delete record

        return redirect()->route('proker.index')->with('success', 'Proker deleted successfully');
    }

    public function deleteImages(Request $request, $id)
    {
        $proker = Proker::findOrFail($id);

        if ($request->has('delete_images')) {
            $deleteImages = $request->input('delete_images');
            $existingImages = explode(',', $proker->fotokegiatan);

            foreach ($deleteImages as $image) {
                if (in_array($image, $existingImages)) {
                    // Remove image from the storage
                    $filePath = public_path('assets/divisi/kegiatan-divisi/' . $image);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // Remove image from the database field
                    $existingImages = array_filter($existingImages, function ($existingImage) use ($image) {
                        return $existingImage !== $image;
                    });
                }
            }

            // Update the database record
            $proker->fotokegiatan = implode(',', $existingImages);
            $proker->save();
        }

        return redirect()->back()->with('success', 'Images deleted successfully.');
    }
}
