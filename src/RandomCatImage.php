<?php

namespace Alexwarman\RandomCatImage;

class RandomCatImage
{
    private $apiUrl;
    private $config;

    public function __construct(?array $config = null)
    {
        $this->config = $config ?? $this->getDefaultConfig();
        $this->apiUrl = $this->config['api_url'] ?? 'https://api.ai-cats.net/v1/cat';
    }

    /**
     * Fetch a random cat image from the API.
     *
     * @return string Base64 encoded image data.
     * @throws \Exception If the API request fails.
     */
    public function get(): string
    {
        // Check if we're in Laravel and caching is enabled
        if ($this->isLaravel() && $this->config['cache']['enabled']) {
            return $this->getCachedImage();
        }

        return $this->fetchImage();
    }

    /**
     * Fetch image directly from API.
     */
    private function fetchImage(): string
    {
        $context = $this->createHttpContext();
        $randomImage = file_get_contents($this->apiUrl, false, $context);

        if ($randomImage === false) {
            throw new \Exception('Failed to fetch cat image from API');
        }

        return base64_encode($randomImage);
    }

    /**
     * Get cached image or fetch new one.
     */
    private function getCachedImage(): string
    {
        if (!function_exists('cache')) {
            return $this->fetchImage();
        }

        $cacheKey = $this->config['cache']['key_prefix'] . 'image_' . date('YmdH');
        $duration = $this->config['cache']['duration'];

        return cache()->remember($cacheKey, $duration * 60, function () {
            return $this->fetchImage();
        });
    }

    /**
     * Create HTTP context for file_get_contents.
     */
    private function createHttpContext()
    {
        $options = [
            'http' => [
                'timeout' => $this->config['http']['timeout'] ?? 30,
                'user_agent' => $this->config['http']['user_agent'] ?? 'Random Cat Image Package',
            ]
        ];

        return stream_context_create($options);
    }

    /**
     * Check if we're running in Laravel.
     */
    private function isLaravel(): bool
    {
        return function_exists('config') && function_exists('app');
    }

    /**
     * Get default configuration.
     */
    private function getDefaultConfig(): array
    {
        if ($this->isLaravel() && function_exists('config')) {
            return config('random-cat-image', $this->getPackageDefaults());
        }

        return $this->getPackageDefaults();
    }

    /**
     * Get package default configuration.
     */
    private function getPackageDefaults(): array
    {
        return [
            'api_url' => 'https://api.ai-cats.net/v1/cat',
            'cache' => [
                'enabled' => false,
                'duration' => 60,
                'key_prefix' => 'random_cat_image_',
            ],
            'http' => [
                'timeout' => 30,
                'user_agent' => 'Random Cat Image Package',
            ],
        ];
    }
}