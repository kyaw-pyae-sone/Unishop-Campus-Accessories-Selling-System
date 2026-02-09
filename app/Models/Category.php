<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static select(string $string, string $string1)
 * @method static create(array $data)
 * @method static where(string $string, mixed $id)
 */
class Category extends Model
{

    use HasFactory;

    //
    protected $fillable = [
        "name"
    ];


}
