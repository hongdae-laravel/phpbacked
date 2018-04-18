<?php

namespace App\Listeners;

use App\Events\ProductsCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Browsershot\Browsershot;

class AddSnapshot
{
    protected $browsershot;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Browsershot $browsershot)
    {
        $this->browsershot = $browsershot;
    }

    /**
     * Handle the event.
     *
     * @param  ProductsCreated $event
     * @param \Spatie\Browsershot\Browsershot $browsershot
     * @return void
     */
    public function handle(ProductsCreated $event)
    {
        $imagePath = $this->makeScreenshotImage($event);

        $this->updateScreenshotUrlToProduct($event, $imagePath);
    }

    protected function makeScreenShotDir($path): void
    {
        if ( ! file_exists(public_path($path))) {
            mkdir(public_path($path));
        }
    }

    /**
     * @param \App\Events\ProductsCreated $event
     * @return string
     */
    protected function makeScreenshotImage(ProductsCreated $event): string
    {
        $this->makeScreenShotDir($path = '/screenshot');

        $imagePath = $path . "/" . md5($event->product->name) . ".png";
        $imageRealPath = public_path($imagePath);

        Browsershot::url($event->product->url)->save($imageRealPath);
        return $imagePath;
    }

    /**
     * @param \App\Events\ProductsCreated $event
     * @param $imagePath
     */
    protected function updateScreenshotUrlToProduct(ProductsCreated $event, $imagePath): void
    {
        $event->product->screenshot = $imagePath;
        $event->product->save();
    }
}
