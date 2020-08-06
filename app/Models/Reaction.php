<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = [
        'to_user_id',
        'from_user_id',
        'status'
    ];

    public function toUserId()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }

    public function fromUserId()
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }
}
