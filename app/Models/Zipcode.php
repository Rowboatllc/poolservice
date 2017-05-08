<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
	protected $table = 'zipcodes';

    protected $fillable = [
        'zipcode', 'city'
    ];

    public $timestamps = false;
}
