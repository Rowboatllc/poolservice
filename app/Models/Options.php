<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
	protected $table = 'options';
        protected $fillable = ['key', 'value'];
        protected $primaryKey = 'key';
        public $timestamps = false;
}
