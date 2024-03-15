<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'priority',
        'title',
        'user_id',
    ];
    protected $appends = [
        'created',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function getCreatedAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
