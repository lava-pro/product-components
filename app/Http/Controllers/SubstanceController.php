<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Substance;
use App\Models\ProductSubstance;

class SubstanceController extends Controller
{
    /**
     * Show substace(s)
     *
     * @param  int|null $id Substance id
     * @return mixed
     */
    public function show(int $id = null)
    {
        if (! is_null($id)) {
            return Substance::findOrFail($id);
        }

        return Substance::all();
    }

    /**
     * Create New Substance
     *
     * @param  \Illuminate\Http\Request  $request
     * @return integer  Substance Id
     */
    public function create(Request $request)
    {
        $substance = Substance::create([
            'name'   => $request->name,
            'status' => 1,
        ]);

        return $substance->id;
    }

    /**
     * Update Substance
     *
     * @param  int  $id   Substance Id
     * @param  \Illuminate\Http\Request  $request
     * @return boolean | \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        $substance = Substance::findOrFail($id);

        foreach ($substance->getFillable() as $field) {
            if (! is_null($request->{$field})) {
                $substance->{$field} = $request->{$field};
            }
        }

        return $substance->save();
    }

    /**
     * Destroy the Substance
     *
     * @param  int  $id  Substance Id
     * @return mixed
     */
    public function delete(int $id)
    {
        $substance = Substance::findOrFail($id);

        if ($substance->delete()) {
            $result = ProductSubstance::where(
                'substance_id',
                $substance->id
            )->delete();
        }

        return $result;
    }

}
