<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'orders';
        protected $fillable = ['user_id', 'service', 'zipcode', 'time', 'cleaning_object', 'water', 'price'];

        protected $casts = [
        'services' => 'array'
    ];
}
