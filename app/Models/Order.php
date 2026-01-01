<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $param)*@method static select(string$string, \Illuminate\Contracts\Database\Query\Expression$raw)
// * // * @method static select(string $string, string $string1)
 */
class Order extends Model
{
    //
    protected $fillable = [
        "user_id",
        "product_id",
        "count",
        "status",
        "order_code"
    ];
}
