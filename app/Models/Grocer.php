<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grocer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'state',
        'password',
        'store_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
