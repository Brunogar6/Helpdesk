<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Meeting extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $casts = [
        'inicio' => 'datetime',
        'termino' => 'datetime',
    ];

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class);
    }
}
