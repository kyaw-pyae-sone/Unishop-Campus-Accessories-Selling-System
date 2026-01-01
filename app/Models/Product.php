<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static get()
 * @method static orderby(string $string, string $string1)
 * @method static select(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6)
 * @method static find(string $string, $id)
 * @method static where(string $string, $id)
 */
class Product extends Model
{
    //
    protected $fillable = [
        "name",
        "price",
        "photo",
        "category_id",
        "description",
        "stock"
    ];

}
