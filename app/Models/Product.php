<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Filable fields
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    /*protected $with = [
        'substances',
    ];*/

    /**
     * Product Substances
     *
     * @return \App\Models\Substance
     */
    public function substances()
    {
        return $this->belongsToMany(Substance::class);
    }

    /**
     * Check if product is hidden (by Admin)
     *
     * @return boolean
     */
    public function isHidden()
    {
        foreach ($this->substances as $item) {
            if ($item->status === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get count found substances for product.
     *
     * @param  array  $substances  Substance ids
     * @return  integer
     */
    public function countMatches(array $substances)
    {
        return $this->substances()
            ->wherePivotIn('substance_id', $substances)
            ->count();
    }

}
