<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class AppModel extends Model
{
    use HasFactory;
    use AppModelPaginate;
    use AppModelDateFormat;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
}
