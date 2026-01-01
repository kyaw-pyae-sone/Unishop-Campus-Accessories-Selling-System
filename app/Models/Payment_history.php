<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $order_code)
 */
class Payment_history extends Model
{
    protected $fillable = [
        'username',
        "phone",
        "address",
        "payslip_image",
        "payment_method",
        "order_code",
        "total_amt"
    ];
}
