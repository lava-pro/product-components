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
            ->withCount('substances')
            ->orderBy('substances_count', 'desc')
            ->get();

        if ($products->count() == 0) {
            return 'Не найдено лекарств...';
        }

        $fives = $products->reject(function ($products) {
            return $products->substances_count < 5;
        });

        if ($fives->count()) {
            return $fives;
        }

        return $products;
    }

}
