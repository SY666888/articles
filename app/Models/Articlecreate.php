<?php

namespace App\Models;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Articlecreate extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;
     protected $table = 'articlecreates';
     //protected $guarded = [];
    protected $fillable = ['id','typeid'];
     public function arctype()
    {
        return $this->belongsTo(Arctype::class,'typeid');
    }

    }
