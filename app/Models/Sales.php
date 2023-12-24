<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
     protected $table = 'sales'; 
     protected $fillable = [
        'order_item_id', 
       
   
                'order_id',
                 'order_date',
                'sale_status',
                 'offer_id',
                'tsin',
                 'sku',
                'product_title',
                 'takealot_url_mobi',
                'selling_price',
                 'quantity',
                'dc',
                 'customer',
                'takealot_url',
                 'success_fee',
                 'fulfillment_fee',
                'courier_collection_fee',
                 'auto_ibt_fee',
                'total_fee',
                'barcode',
                
       
    ];
}
