<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Expr\AssignOp\Div;


class Division extends Model
{
    use HasFactory;

    protected $guarded =['id','created_at','updated_at','deleted_at'] ;
  //  protected $fillable = ['division_name', 'division_parent_name'];
    public static $columnNames;



    public static function searchDivision($searchDivision)
    {

        return empty($searchDivision) ? static::query()
            : static::query()->where('division_name', 'like', '%' . $searchDivision . '%')
                ->orWhere('division_parent_name', 'like', '%' . $searchDivision . '%');
    }


}
