<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alexwarman\RandomCatImage\Facades\RandomCatImage;
use Alexwarman\RandomCatImage\RandomCatImage as RandomCatImageService;

class CatController extends Controller
{
    /**
     * Display a random cat image using facade.
     */
    public function index()
    {
        try {
            $catImage = RandomCatImage::get();
            
            return view('cat.index', compact('catImage'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to fetch cat image: ' . $e->getMessage());
        }
    }

    /**
     * Get a random cat image as JSON API response.
     */
    public function api()
    {
        try {
            $catImage = RandomCatImage::get();
            
            return response()->json([
                'success' => true,
                'image' => 'data:image/jpeg;base64,' . $catImage,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download a random cat image using dependency injection.
     */
    public function download(RandomCatImageService $catImageService)
    {
        try {
            $catImage = $catImageService->get();
            $imageData = base64_decode($catImage);
            
            return response($imageData)
                ->header('Content-Type', 'image/jpeg')
                ->header('Content-Disposition', 'attachment; filename="random-cat-' . time() . '.jpg"');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to download cat image: ' . $e->getMessage());
        }
    }

    /**
     * Save a random cat image to storage.
     */
    public function save(Request $request)
    {
        try {
            $catImage = RandomCatImage::get();
            $imageData = base64_decode($catImage);
            
            $filename = 'random-cat-' . time() . '.jpg';
            $path = storage_path('app/public/cats/' . $filename);
            
            // Create directory if it doesn't exist
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            
            file_put_contents($path, $imageData);
            
            return back()->with('success', 'Cat image saved as: ' . $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to save cat image: ' . $e->getMessage());
        }
    }
}
