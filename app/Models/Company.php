<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $table = 'companys';

    protected $fillable = [
        'user_id', 'name', 'services', 'zipcodes','logo','status','website'
    ];

    protected $casts = [
        'services' => 'array',
        'zipcodes' => 'array',
    ];

    public function ratings() {
        return $this->hasMany('App\Models\Rating', 'company_id');
    }
}
