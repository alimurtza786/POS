<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Woos extends Model
{
    use HasFactory;

    protected $table = 'woos'; // Assuming your table name is 'woos'

    protected $fillable = [
        'id',
        'code',
        'name',
        'unit',
        'cost',
        'price',
        'alert_quantity',
        'image',
        'category_id',
        'cf1',
        'cf2',
        'cf3',
        'cf4',
        'cf5',
        'cf6',
        'quantity',
        'tax_rate',
        'track_quantity',
        'details',
        'warehouse',
        'barcode_symbology',
        'file',
        'product_details',
        'tax_method',
        'type',
        'supplier1',
        'supplier1price',
        'supplier2',
        'supplier2price',
        'supplier3',
        'supplier3price',
        'supplier4',
        'supplier4price',
        'supplier5',
        'supplier5price',
        'promotion',
        'promo_price',
        'start_date',
        'end_date',
        'supplier1_part_no',
        'supplier2_part_no',
        'supplier3_part_no',
        'supplier4_part_no',
        'supplier5_part_no',
        'sale_unit',
        'purchase_unit',
        'brand',
        'slug',
        'featured',
        'weight',
        'hsn_code',
        'views',
        'hide',
        'second_name',
        'hide_pos',
        'rack',
        'stack_handler',
        'barcode',
    ];
}
