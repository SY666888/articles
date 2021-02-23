<?php
namespace App\Models;
use Dcat\Admin\Models\Administrator as AdminUser;
class Administrator extends AdminUser
{
    public function kehuxiansuo()
    {
        return $this->hasMany(Kehuxiansuo::class,'tracer_id');
    }
}
