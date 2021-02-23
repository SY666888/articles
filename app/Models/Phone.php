<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;
    protected $table = 'phones';
    protected $guarded = [];
    public function kehuxiansuo()
    {
        return $this->hasOne(Kehuxiansuo::class);
    }
    public function user()
    {
        return $this->hasMany(Administrator::class,'id');
    }
    }
