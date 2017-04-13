<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PoolSubscriber extends Model
{
	protected $table = 'orders';
        protected $fillable = [
            'user_id', 'services', 'zipcode', 'time', 'cleaning_object', 'water', 'price'
        ];

        protected $casts = [
        'services' => 'array',
        'zipcode' => 'array',        
    ];
}
