<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Lending extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory;
    use Auditable;

    protected $casts = [
        'inicio' => 'datetime',
        'previsto' => 'datetime',
        'fim' => 'datetime',
    ];

    protected $fillable = [
        'devolvido', 'fim'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');

    }
}
