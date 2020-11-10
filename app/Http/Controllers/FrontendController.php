<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FrontendController extends Controller
{
    /**
     * Find the product by specific substances.
     * $request->substances = [1,2,3,5,7]
     *
     * @param  \lluminate\Http\Request $request
     * @return  mixed
     */
    public function findProducts(Request $request)
    {
        $substances = $request->substances;

        if (empty($substances) || count($substances) < 2) {
            return 'Не ленись, добавь веществ...';
        }

        $products = Product::where('status', 1)->get();

        $results = [];

        foreach ($products as $product) {
            if ($product->isHidden()) {
                continue;
            }

            $matches = $product->countMatches($substances);

            // Add result if more than one match
            if ($matches > 1) {
                $product->order = $matches;
                $results[] = $product;
            }
        }

        if (count($results) == 0) {
            return 'Не найдено лекарств...';
        }

        // Try extract the products with $matches == 5
        $collection = collect($results)
            ->reject(function ($product) {
                return $product->order < 5;
            });

        if ($collection->count()) {
            return $collection;
        }

        // Sort the collection with reverse (for desc)
        $collection = collect($results)
            ->sortBy('order')
            ->values()
            ->reverse()
            ->all();

        return $collection;
    }

}
