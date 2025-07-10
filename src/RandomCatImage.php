<?php

namespace Alexwarman\RandomCatImage;

class RandomCatImage
{
    private $apiUrl = 'https://api.ai-cats.net/v1/cat';

    /**
     * Fetch a random cat image from the API.
     *
     * @return string Base64 encoded image data.
     * @throws \Exception If the API request fails.
     */
    public function get(): string
    {
        $randomImage = file_get_contents($this->apiUrl);

        if ($randomImage === false) {
            throw new \Exception('Failed to fetch cat image from API');
        }

        return base64_encode($randomImage);
    }
}