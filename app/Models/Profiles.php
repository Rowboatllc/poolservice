<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
	protected $fillable = ['first_name', 'last_name','full_name','street', 'city', 'state', 'zip','phone'];
	protected $table = 'profiles';
	protected $primaryKey = 'user_id';
}
