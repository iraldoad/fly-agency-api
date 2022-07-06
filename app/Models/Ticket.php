<?php

namespace App\Models;

class Ticket extends AppModel
{
    public function flight(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
}
