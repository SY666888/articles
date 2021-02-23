<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'links';
    /**
     * @var array 允许批量赋值属性
     */
    protected $fillable = [
        'linktype', 'title', 'url', 'logo', 'beizhu', 'expired_at'
    ];
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'expired_at',
        'created_at',
        'updated_at',
    ];


}
