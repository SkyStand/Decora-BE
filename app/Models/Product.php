<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    protected $fillable = ['image', 'name', 'description', 'type', 'category', 'style'];
}
