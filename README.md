# Random Cat Image

A PHP library to fetch random cat images from ai-cats.net.

## Description

This package provides a simple and easy way to get random cat images in your PHP applications. Returns base64 encoded image data that you can use directly in your web applications or save to files. Perfect for adding some feline fun to your projects!

## Installation

Install via Composer:

```bash
composer require alexwarman/random-cat-image
```

## Usage

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

## Requirements

- PHP 7.4 or higher
- No external dependencies required

## Features

- Fetch random cat images from ai-cats.net
- Returns base64 encoded image data
- Ready for direct use in HTML or saving to files
- Simple and lightweight
- PSR-4 autoloading compatible
- No external dependencies

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

**Alex Warman**
- Email: alex.warman@gmail.com

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

If you encounter any issues or have questions, please open an issue on the GitHub repository.
