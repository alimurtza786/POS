<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     protected $table = 'products'; 
    protected $fillable = [
        'tsin_id',
        'image_url',
        'offer_id',
        'sku',
        'barcode',
        'product_label_number',
        'selling_price',
        'rrp',
        'leadtime_days',
        'status',
        'title',
        'offer_url',
        'total_stock_on_way',
        'total_stock_cover',
        'stock_at_takealot_total',
        'date_created',
        'discount',
        'discount_shown',
        'replen_block_jhb',
        'replen_block_cpt',
    ];

    protected $casts = [
        'leadtime_stock' => 'array',
        'stock_at_takealot' => 'array',
        'stock_on_way' => 'array',
        'stock_cover' => 'array',
        'sales_units' => 'array',
        'storage_fee_eligible' => 'json',
    ];
}
