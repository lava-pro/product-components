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
     * Get the fillable fields
     *
     * @return array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Product Substances
     *
     * @return \App\Models\Substance
     */
    public function substances()
    {
        return $this->belongsToMany(Substance::class);
    }

}
