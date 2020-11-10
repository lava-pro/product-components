<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubstance extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'product_substance';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'substance_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
