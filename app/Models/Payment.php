<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static select(string $string)
 */
class Payment extends Model
{
    //
    protected $fillable = [
        "account_number",
        "account_name",
        "account_type"
    ];
}
