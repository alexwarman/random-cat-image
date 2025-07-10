# Laravel Integration Guide

This guide shows how to integrate the Random Cat Image package seamlessly with Laravel.

## Installation

1. **Install the package via Composer:**
   ```bash
   composer require alexwarman/random-cat-image
   ```

2. **For Laravel 5.5+:** The package will be automatically discovered.

3. **For older Laravel versions:** Manually add the service provider and facade:
   ```php
   // config/app.php
   'providers' => [
       // ...
       Alexwarman\RandomCatImage\RandomCatImageServiceProvider::class,
   ],

   'aliases' => [
       // ...
       'RandomCatImage' => Alexwarman\RandomCatImage\Facades\RandomCatImage::class,
   ],
   ```

## Configuration

1. **Publish the configuration file (optional):**
   ```bash
   php artisan vendor:publish --tag=random-cat-image-config
   ```

2. **Configure via environment variables:**
   ```env
   # .env
   RANDOM_CAT_API_URL=https://api.ai-cats.net/v1/cat
   RANDOM_CAT_CACHE_ENABLED=true
   RANDOM_CAT_CACHE_DURATION=60
   RANDOM_CAT_HTTP_TIMEOUT=30
   RANDOM_CAT_USER_AGENT="My Laravel App"
   ```

## Usage Examples

### 1. Using the Facade

```php
use Alexwarman\RandomCatImage\Facades\RandomCatImage;

// In a controller
public function getCat()
{
    $catImage = RandomCatImage::get();
    return view('cat', compact('catImage'));
}

// In a route closure
Route::get('/cat', function () {
    return response()->json([
        'image' => 'data:image/jpeg;base64,' . RandomCatImage::get()
    ]);
});
```

### 2. Using Dependency Injection

```php
use Alexwarman\RandomCatImage\RandomCatImage;

class CatService
{
    protected $catImage;

    public function __construct(RandomCatImage $catImage)
    {
        $this->catImage = $catImage;
    }

    public function getRandomCat()
    {
        return $this->catImage->get();
    }
}
```

### 3. Using the Service Container

```php
// Anywhere in your Laravel app
$catImage = app('random-cat-image')->get();

// Or using the helper
$catImage = resolve('random-cat-image')->get();
```

### 4. In Blade Templates

```blade
@php
    $catImage = app('random-cat-image')->get();
@endphp

<img src="data:image/jpeg;base64,{{ $catImage }}" alt="Random Cat" />
```

### 5. Artisan Commands

```bash
# Get a random cat image (displays base64 data)
php artisan cat:random

# Save a random cat image to file
php artisan cat:random --save=storage/app/public/cat.jpg
```

## Advanced Usage

### Caching

Enable caching in your configuration:

```php
// config/random-cat-image.php
'cache' => [
    'enabled' => true,
    'duration' => 60, // minutes
    'key_prefix' => 'random_cat_image_',
],
```

### Custom HTTP Configuration

```php
// config/random-cat-image.php
'http' => [
    'timeout' => 30,
    'user_agent' => 'My Laravel App v1.0',
],
```

### Creating a Service Class

```php
<?php

namespace App\Services;

use Alexwarman\RandomCatImage\Facades\RandomCatImage;
use Illuminate\Support\Facades\Storage;

class CatImageService
{
    public function getRandomCat(): string
    {
        return RandomCatImage::get();
    }

    public function saveRandomCat(string $filename = null): string
    {
        $catImage = $this->getRandomCat();
        $filename = $filename ?: 'cat-' . time() . '.jpg';
        
        Storage::disk('public')->put(
            'cats/' . $filename,
            base64_decode($catImage)
        );
        
        return $filename;
    }

    public function getCatImageUrl(string $filename): string
    {
        return Storage::disk('public')->url('cats/' . $filename);
    }
}
```

### Scheduled Tasks

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $catImage = app('random-cat-image')->get();
        Storage::disk('public')->put(
            'daily-cat/' . date('Y-m-d') . '.jpg',
            base64_decode($catImage)
        );
    })->daily();
}
```

### Queue Jobs

```php
<?php

namespace App\Jobs;

use Alexwarman\RandomCatImage\RandomCatImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessRandomCatImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(RandomCatImage $catImage)
    {
        $base64Image = $catImage->get();
        $imageData = base64_decode($base64Image);
        
        $filename = 'processed-cat-' . time() . '.jpg';
        Storage::disk('public')->put('processed/' . $filename, $imageData);
        
        // Additional processing...
    }
}
```

## Testing

You can mock the service in your tests:

```php
use Alexwarman\RandomCatImage\RandomCatImage;
use Tests\TestCase;

class CatImageTest extends TestCase
{
    public function test_can_get_cat_image()
    {
        $this->mock(RandomCatImage::class, function ($mock) {
            $mock->shouldReceive('get')
                 ->once()
                 ->andReturn('fake-base64-data');
        });

        $response = $this->get('/api/cat/random');
        
        $response->assertStatus(200)
                 ->assertJson(['image' => 'data:image/jpeg;base64,fake-base64-data']);
    }
}
```

## Troubleshooting

### Package Not Auto-Discovered

If the package isn't auto-discovered, manually register it:

```php
// config/app.php
'providers' => [
    Alexwarman\RandomCatImage\RandomCatImageServiceProvider::class,
],
```

### Facade Not Working

Make sure the alias is registered:

```php
// config/app.php
'aliases' => [
    'RandomCatImage' => Alexwarman\RandomCatImage\Facades\RandomCatImage::class,
],
```

### API Timeout Issues

Increase the timeout in configuration:

```env
RANDOM_CAT_HTTP_TIMEOUT=60
```

### Memory Issues with Large Images

Enable caching to reduce API calls:

```env
RANDOM_CAT_CACHE_ENABLED=true
RANDOM_CAT_CACHE_DURATION=120
```
