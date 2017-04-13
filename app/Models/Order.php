<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'orders';
        protected $fillable = [
            'user_id', 'services', 'zipcode', 'time', 'cleaning_object', 'water', 'price', 'status'
        ];

        protected $casts = [
        'services' => 'array',
        'zipcode' => 'array',        
        'cleaning_object'=>'array',
    ];
}
