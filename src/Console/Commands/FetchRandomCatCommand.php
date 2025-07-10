<?php

namespace Alexwarman\RandomCatImage\Console\Commands;

use Illuminate\Console\Command;
use Alexwarman\RandomCatImage\RandomCatImage;

class FetchRandomCatCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'cat:random {--save= : Save the image to a file path}';

    /**
     * The console command description.
     */
    protected $description = 'Fetch a random cat image from ai-cats.net';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Fetching a random cat image...');

        try {
            $randomCatImage = new RandomCatImage();
            $base64Image = $randomCatImage->get();

            if ($this->option('save')) {
                $savePath = $this->option('save');
                file_put_contents($savePath, base64_decode($base64Image));
                $this->info("Cat image saved to: {$savePath}");
            } else {
                $this->line('Base64 encoded image data:');
                $this->line($base64Image);
                $this->newLine();
                $this->info('You can use this in HTML as: <img src="data:image/jpeg;base64,' . substr($base64Image, 0, 50) . '..." />');
            }

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to fetch cat image: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
