<?php

namespace App\Models;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehuxiansuo extends Model
{   use HasDateTimeFormatter;
    use HasFactory;
    protected $table = 'kehuxiansuos';
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function phone()
    {
        return $this->belongsTo(Phone::class,'phone_id');
    }
    public function user()
    {
        return $this->belongsTo(Administrator::class,'tracer_id');
    }

}
