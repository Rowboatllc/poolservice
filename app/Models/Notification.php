<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	protected $table = 'notifications';
        protected $fillable = ['user_id', 'content', 'opened'];
}
