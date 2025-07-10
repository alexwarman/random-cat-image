<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatController;

/*
|--------------------------------------------------------------------------
| Random Cat Image Routes
|--------------------------------------------------------------------------
|
| Here are some example routes for using the Random Cat Image package
| in your Laravel application. Add these to your routes/web.php file.
|
*/

Route::prefix('cat')->name('cat.')->group(function () {
    // Display random cat image page
    Route::get('/', [CatController::class, 'index'])->name('index');
    
    // Download cat image
    Route::get('/download', [CatController::class, 'download'])->name('download');
    
    // Save cat image to storage
    Route::post('/save', [CatController::class, 'save'])->name('save');
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Add these to your routes/api.php file for API endpoints.
|
*/

Route::prefix('api/cat')->group(function () {
    // Get random cat image as JSON
    Route::get('/random', [CatController::class, 'api'])->name('cat.api');
});

/*
|--------------------------------------------------------------------------
| Using Facade in Route Closures
|--------------------------------------------------------------------------
|
| You can also use the facade directly in route closures for simple use cases.
|
*/

use Alexwarman\RandomCatImage\Facades\RandomCatImage;

Route::get('/quick-cat', function () {
    try {
        $catImage = RandomCatImage::get();
        
        return response()->json([
            'image' => 'data:image/jpeg;base64,' . $catImage,
            'message' => 'Here is your random cat! 🐱'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/cat-page', function () {
    try {
        $catImage = RandomCatImage::get();
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Quick Cat</title>
            <style>
                body { text-align: center; font-family: Arial, sans-serif; padding: 20px; }
                img { max-width: 100%; height: auto; border-radius: 10px; }
            </style>
        </head>
        <body>
            <h1>🐱 Random Cat Image</h1>
            <img src='data:image/jpeg;base64,{$catImage}' alt='Random Cat' />
            <br><br>
            <a href='/cat-page'>🔄 Get Another Cat</a>
        </body>
        </html>
        ";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
