<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Search;
use Modules\Shop\Http\Models\Shop;

class SearchService
{
    /**
     * Popular Suggestion
     */
    public function getPopularSuggestion(string $keyword): array
    {
        return Search::whereLike('name', $keyword)->orderByDesc('total')->limit(5)->pluck('name')->toArray();
    }

    /**
     * Popular Categories
     */
    public function getPopularCategories(string $keyword): array
    {
        return Category::whereLike('name', $keyword)
            ->orWhere('slug', 'like', '%' . $keyword . '%')
            ->where('status', 'Active')
            ->leftJoin('category_stats', 'categories.id', 'category_stats.category_id')
            ->orderByDesc('count_sales')
            ->limit(3)
            ->pluck('name', 'slug')->toArray();
    }

    /**
     * Products
     */
    public function getProducts(string $keyword): array
    {
        return Product::whereNull('parent_id')
            ->whereLike('name', $keyword)
            ->orWhere('slug', 'like', '%' . $keyword . '%')
            ->orWhere('sku', 'like', '%' . $keyword . '%')
            ->isActiveVendor()
            ->limit(3)
            ->get()
            ->map(function ($product) {
                return [
                    'title' => $product->name,
                    'slug' => $product->slug,
                    'image' => $product->getFeaturedImage('small'),
                    'price' => $product->getFormattedSalePrice() ?? $this->getProductFormatPrice($product),
                ];
            })->toArray();
    }

    /**
     * Get Product Format Price
     */
    private function getProductFormatPrice(Product $product): string
    {
        $variationPrice = $product->getPrice();

        if (! is_array($variationPrice)) {
            return formatNumber($variationPrice);
        }

        [$minPrice, $maxPrice] = $variationPrice;

        return formatNumber($minPrice) . ' - ' . formatNumber($maxPrice);
    }

    /**
     * Shops
     */
    public function getShops(string $keyword): array
    {
        return Shop::whereLike('name', $keyword)
            ->orWhere('alias', 'like', '%' . $keyword . '%')
            ->isActiveVendor()
            ->limit(3)
            ->get()
            ->map(function ($shop) {
                return [
                    'title' => $shop->name,
                    'image' => $shop?->vendor?->logo?->fileUrl() ?? $shop?->vendor?->fileUrl() ?? defaultImage('shop'),
                    'phone' => $shop->phone,
                    'alias' => $shop->alias,
                ];
            })->toArray();
    }
}
