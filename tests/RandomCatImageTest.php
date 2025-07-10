<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Alexwarman\RandomCatImage\RandomCatImage;

class RandomCatImageTest extends TestCase
{
    public function test_can_fetch_random_cat_image()
    {
        $catImage = new RandomCatImage();
        $result = $catImage->get();

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
        // Base64 encoded data should be valid
        $this->assertNotFalse(base64_decode($result, true));
    }

    public function test_can_use_custom_config()
    {
        $config = [
            'api_url' => 'https://api.ai-cats.net/v1/cat',
            'cache' => ['enabled' => false],
            'http' => ['timeout' => 10]
        ];

        $catImage = new RandomCatImage($config);
        $result = $catImage->get();

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }
}
