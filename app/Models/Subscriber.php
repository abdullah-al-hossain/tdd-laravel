<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $casts = [
        'meta' => 'array',
    ];

    protected $guarded = [];

    public function list()
    {
        return $this->belongsTo(EmailList::class);
    }
}
