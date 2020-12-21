<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected  $guarded=[''];
    protected $casts=[

    ];
    public static function search($search)
    {

        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('document_name', 'like', '%'.$search.'%')
                ->orWhere('document_number', 'like', '%'.$search.'%');
    }
}
