<?php

namespace App\Models;

use DateTimeInterface;

trait AppModelDateFormat
{
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format(config('app.datetime_format'));
    }
}
