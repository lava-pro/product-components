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

        $products = Product::where('status', 1)
            ->whereDoesntHave('substances', function ($query) {
                $query->where('substances.status', 0);
            })
            ->whereHas('substances', function ($query) use ($substances) {
                $query->whereIn('substances.id', $substances);
            }, '>=', 2)
            ->get();

        if ($products->count() == 0) {
            return 'Не найдено лекарств...';
        }

        $results = [];

        foreach ($products as $product) {
            $order = $product->countMatches($substances);
            $product->order = $order;
            $results[] = $product;
        }

        // Try extract the products with $matches == 5
        $fives = collect($results)
            ->reject(function ($product) {
                return $product->order < 5;
            });

        if ($fives->count()) {
            return $fives;
        }

        // Sort the collection with reverse (for desc)
        $sorteds = collect($results)
            ->sortBy('order')
            ->values()
            ->reverse()
            ->all();

        return $sorteds;
    }

}
