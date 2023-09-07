<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'state',
        'codeSAP',
        'ubicaciones',
        'country_id',
    ];

    public function grocers()
    {
        return $this->hasMany(Grocer::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
