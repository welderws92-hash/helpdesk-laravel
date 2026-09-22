<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'department_id',
        'title',
        'requester_name',
        'priority',
        'description',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}