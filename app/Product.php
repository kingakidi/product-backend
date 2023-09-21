<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 6/29/2018
 * Time: 9:17 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $fillable = [
        'batch_id',
        'product_name',
        'manufacturer',
        'barcode',
        'quantity',
        'price',
        'manufacturing_date',
        'expiry_date',
    ];
}