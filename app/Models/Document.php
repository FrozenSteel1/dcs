<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected  $guarded=[''];
    protected $casts=[
       'document_area'=>'array' ,
        'document_responsible_id'=>'array' ,
        'document_signer_id'=>'array' ,
        'document_tags'=>'array' ,
        'document_data'=>'array' ,
    ];
    public static function search($search)
    {

        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('document_name', 'like', '%'.$search.'%')
                ->orWhere('document_number', 'like', '%'.$search.'%');
    }
}
