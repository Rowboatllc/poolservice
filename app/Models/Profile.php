<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $fillable = [
		'user_id','first_name', 'last_name','full_name','street', 'city', 'state', 'zip','phone','avatar'
	];
	protected $table = 'profiles';
	protected $primaryKey = 'user_id';
}
