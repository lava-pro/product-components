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
     * @param   \lluminate\Http\Request $request
     * @return  \Illuminate\Http\Resources\Json 
     */
    public function findProducts(Request $request)
    {
        $substances = $request->substances;

        if (empty($substances) || count($substances) < 2) {
            return ['Nothing to search...'];
        }

        $products = Product::where('status', 1)
            ->whereDoesntHave('substances', function ($query) {
                $query->where('substances.status', 0);
            })
            ->whereHas('substances', function ($query) use ($substances) {
                $query->whereIn('substances.id', $substances);
            }, 5);

        if ($products->get()->count()) {
            return $products->get();
        }

        $products->orWhereHas('substances', function ($query) use ($substances) {
                $query->whereIn('substances.id', $substances);
            }, '>=', 2)
            ->withCount('substances')
            ->orderBy('substances_count', 'desc');

        if ($products->count()) {
            return $products->get();
        }

        return ['Nothing found...'];
    }

}
