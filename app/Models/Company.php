<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $table = 'companys';

    protected $fillable = [
        'name', 'services', 'zipcode', 'address','logo','status','token','website'
    ];

    protected $casts = [
        'services' => 'array',
        'zipcode' => 'array',
    ];

    public function ratings() {
        return $this->hasMany('App\Models\Rating', 'company_id');
    }
}
