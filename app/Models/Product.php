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
    protected $with = [
        'substances',
    ];

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
