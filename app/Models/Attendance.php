<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainee_id',
        'batch_id',
        'date',
        'status',
        'note',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}

