<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	protected $table = 'schedules';

    protected $fillable = [
        'selected_id', 'technician_id', 'date', 'img_before', 'img_after', 'status', 'cleaning_steps', 'comment'
    ];

    protected $casts = [
        'cleaning_steps' => 'array',
    ];
}
