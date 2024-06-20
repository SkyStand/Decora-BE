<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['variant_id', 'qty'];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}