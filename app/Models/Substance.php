<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Substance extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'substances';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status',
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
     * Products
     *
     * @return \App\Models\Product
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
