<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    protected  $guarded=[''];
    public static function searchWorker($searchWorker)
    {

        return empty($searchWorker) ? static::query()
            : static::query()->where('worker_surname', 'like', '%'.$searchWorker.'%')
                ->orWhere('worker_name', 'like', '%'.$searchWorker.'%');
    }
}
