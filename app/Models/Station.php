<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = [
        'location',
        'status',
    ];

    public function powerbanks()
    {
        return $this->hasMany(Powerbank::class);
    }
}
