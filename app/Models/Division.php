<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected  $guarded=[''];
    public static function searchDivision($searchDivision)
    {

        return empty($searchDivision) ? static::query()
            : static::query()->where('division_name', 'like', '%'.$searchDivision.'%');
    }
}
