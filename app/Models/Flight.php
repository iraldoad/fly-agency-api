<?php

namespace App\Models;

class Flight extends AppModel
{
    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
