<?php

namespace App\Http\Controllers;

use App\Events\ProductsCreated;
use App\Http\Requests\StoreProductsRequest;
use App\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Spatie\Url\Url;

class ProductsController extends Controller
{
    public function store(StoreProductsRequest $request, Client $guzzle)
    {
        $refinedUrl = $this->refineUrl($guzzle, $request->input('url'));

        if(!$this->url_exists($refinedUrl)){
            return response("{$refinedUrl} is not valid URL.");
        }

        $metaTags = get_meta_tags($refinedUrl);

        $product = Product::create([
            'url' => $refinedUrl,
            'name' => $request->input('name'),
            'description' => $metaTags['description'] ?? ''
        ]);

        event(new ProductsCreated($product));

        return $product;
    }

    public function index(Request $request, Product $product)
    {
        return $product->latest()->paginate(12);
    }

    public function create()
    {
        return view('products.create');
    }

    /**
     * 애플리케이션의 URL을 저장하기 위해 입력받은 URL에서 스킴과 도메인만 남긴다.
     * 스킴은 https를 우선으로 한다.
     * @param \GuzzleHttp\Client $guzzle
     * @param $url
     * @return string
     */
    protected function refineUrl(Client $guzzle, $url): string
    {
        $url = Url::fromString($url);

        $scheme = $url->getScheme();
        if ($scheme != 'https') {
            try {
                $res = $guzzle->get('https://' . $url->getHost());
                if ($res->getStatusCode() == 200) {
                    $scheme = 'https';
                }
            } catch(\Exception $e) {
                // do nothing
            }
        }

        $refinedUrl = $scheme . "://" . $url->getHost();

        return $refinedUrl;
    }

    public function url_exists($url) {
        if (!$fp = curl_init($url)) return false;
        return true;
    }
}
