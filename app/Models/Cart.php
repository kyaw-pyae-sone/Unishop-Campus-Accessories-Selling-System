<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(array $array)
 * @method static select(string $string, string $string1, string $string2, string $string3, string $string4, string $string5)
 */
class Cart extends Model
{
    //
    protected $fillable = [
        "user_id",
        "product_id",
        "qty"
    ];
}
