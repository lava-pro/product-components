<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSubstance;

class ProductController extends Controller
{
    /**
     * Show product(s)
     *
     * @param  int|null $id Product id
     * @return mixed
     */
    public function show(int $id = null)
    {
        if (! is_null($id)) {
            return Product::findOrFail($id);
        }

        return Product::all();
    }

    /**
     * Create New Product
     *
     * @param  \Illuminate\Http\Request  $request
     * @return integer  Product Id
     */
    public function create(Request $request)
    {
        $product = Product::create([
            'name'   => $request->name,
            'status' => 1,
        ]);

        $productSubstances = [];

        if (! empty($request->substances) && is_array($request->substances)) {
            foreach ($request->substances as $substance_id) {
                $productSubstances[] = [
                    'product_id'   => $product->id,
                    'substance_id' => $substance_id,
                ];
            }
        }

        if (! empty($productSubstances)) {
            ProductSubstance::insert($productSubstances);
        }

        return $product->id;
    }

    /**
     * Update Product
     *
     * @param  int  $id   Product Id
     * @param  \Illuminate\Http\Request  $request
     * @return boolean | \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        $product = Product::findOrFail($id);

        foreach ($product->getFillable() as $field) {
            if (! is_null($request->{$field})) {
                $product->{$field} = $request->{$field};
            }
        }

        $productSubstances = [];

        if (! empty($request->substances) && is_array($request->substances)) {
            foreach ($request->substances as $substance_id) {
                $productSubstances[] = [
                    'product_id'   => $product->id,
                    'substance_id' => $substance_id,
                ];
            }
        }

        if (! empty($productSubstances)) {
            ProductSubstance::where('product_id', $product->id)->delete();
            ProductSubstance::insert($productSubstances);
        }

        return $product->save();
    }

    /**
     * Destroy the Product
     *
     * @param  int  $id  Product Id
     * @return mixed
     */
    public function delete(int $id)
    {
        $product = Product::findOrFail($id);

        if ($product->delete()) {
            $result = ProductSubstance::where(
                'product_id',
                $product->id
            )->delete();
        }

        return $result;
    }

}
