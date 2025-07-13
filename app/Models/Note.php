<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'title', 'content'];

    protected $casts = [
    'is_favorite' => 'boolean',
];


    public function user() {
        return $this->belongsTo(User::class);
    }
}
