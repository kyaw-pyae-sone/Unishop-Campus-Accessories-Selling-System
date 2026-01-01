<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Comment extends Model
{
    //

    protected $fillable = [
        "user_id",
        "product_id",
        "message"
    ];
}
