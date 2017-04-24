<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	protected $table = 'schedules';

    protected $fillable = [
        'technican_id', 'order_id', 'company_id', 'date', 'img_before', 'img_after', 'status', 'cost', 'cleaning_steps', 'comment'
    ];
}
