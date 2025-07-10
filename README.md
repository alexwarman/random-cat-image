# Random Cat Image

A PHP library to fetch random cat images from ai-cats.net with seamless Laravel integration.

## Description

This package provides a simple and easy way to get random cat images in your PHP applications. Returns base64 encoded image data that you can use directly in your web applications or save to files. Perfect for adding some feline fun to your projects!

**Laravel Features:**
- Auto-discovery service provider
- Dependency injection support
- Configuration file for customization
- Built-in caching support
- Environment variable configuration

## Installation

Install via Composer:

```bash
composer require alexwarman/random-cat-image
```

### Laravel Setup

For Laravel 5.5+, the package will be automatically discovered. For older versions, add the service provider manually:

```php
// config/app.php
'providers' => [
    // ...
    Alexwarman\RandomCatImage\RandomCatImageServiceProvider::class,
],
```

Optionally, publish the configuration file:

```bash
php artisan vendor:publish --tag=random-cat-image-config
```

## Usage

### Basic PHP Usage

```php
<?php
require_once 'vendor/autoload.php';

use Alexwarman\RandomCatImage\RandomCatImage;

$randomCatImage = new RandomCatImage();
$base64Image = $randomCatImage->get();

// Display in HTML
echo '<img src="data:image/jpeg;base64,' . $base64Image . '" alt="Random Cat" />';

// Or save to file
file_put_contents('cat.jpg', base64_decode($base64Image));
```

### Laravel Usage

#### Using Dependency Injection (Recommended)

```php
use Alexwarman\RandomCatImage\RandomCatImage;

class CatController extends Controller
{
    public function show(RandomCatImage $catImage)
    {
        $base64Image = $catImage->get();
        
        return response()->json([
            'image' => 'data:image/jpeg;base64,' . $base64Image
        ]);
    }
}
```

#### Using Service Container

```php
// Get instance from container
$catImage = app('random-cat-image')->get();

// Or using resolve helper
$catImage = resolve('random-cat-image')->get();
```

#### In Blade Templates

```blade
@inject('catService', 'random-cat-image')

<img src="data:image/jpeg;base64,{{ $catService->get() }}" alt="Random Cat" class="img-fluid" />
```

### Configuration

The package can be configured through environment variables or the published config file:

```env
# .env file
RANDOM_CAT_API_URL=https://api.ai-cats.net/v1/cat
RANDOM_CAT_CACHE_ENABLED=true
RANDOM_CAT_CACHE_DURATION=60
RANDOM_CAT_HTTP_TIMEOUT=30
RANDOM_CAT_USER_AGENT="My Laravel App"
```

Or in the configuration file (`config/random-cat-image.php`):

```php
return [
    'api_url' => 'https://api.ai-cats.net/v1/cat',
    'cache' => [
        'enabled' => true,
        'duration' => 60, // minutes
        'key_prefix' => 'random_cat_image_',
    ],
    'http' => [
        'timeout' => 30,
        'user_agent' => 'My Laravel App',
    ],
];
```

## Requirements

- PHP 7.4 or higher
- Laravel 8.0+ (optional, for Laravel features)

## Features

- Fetch random cat images from ai-cats.net
- Returns base64 encoded image data
- Ready for direct use in HTML or saving to files
- Simple and lightweight
- PSR-4 autoloading compatible
- **Laravel Integration:**
  - Auto-discovery service provider
  - Dependency injection support
  - Configuration file
  - Built-in caching
  - Environment variable support

## Laravel Examples

### Creating a Cat Image API Endpoint

```php
// routes/api.php
use Alexwarman\RandomCatImage\RandomCatImage;

Route::get('/random-cat', function (RandomCatImage $catService) {
    return response()->json([
        'image' => 'data:image/jpeg;base64,' . $catService->get(),
        'timestamp' => now()
    ]);
});
```

### Scheduled Cat Images

```php
// app/Console/Kernel.php
use Alexwarman\RandomCatImage\RandomCatImage;

protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $catImage = app('random-cat-image')->get();
        // Store or process the image
    })->daily();
}
```

### Using in a Job

```php
use Alexwarman\RandomCatImage\RandomCatImage;
use Illuminate\Bus\Queueable;

class FetchRandomCatJob implements ShouldQueue
{
    use Queueable;

    public function handle(RandomCatImage $catImage)
    {
        $base64Image = $catImage->get();
        // Process the image
    }
}
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

**Alex Warman**
- Email: alex.warman@gmail.com

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

If you encounter any issues or have questions, please open an issue on the GitHub repository.
