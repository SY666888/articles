<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\ModelTree;

class Arctype extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use ModelTree;
     protected $table = 'arctypes';
     //设置允许写入的数据字段
     protected $fillable = ['id','typename'];
    //设置禁止写入的字段
    //protected $guarded = [];
    // 父级ID字段名称，默认值为 parent_id
    protected $parentColumn = 'parent_id';

    // 排序字段名称，默认值为 order
    protected $orderColumn = 'order';

    // 标题字段名称，默认值为 title
    protected $titleColumn = 'title';
    public function articlecreate()
    {
        return $this->hasMany(Articlecreate::class,'typeid');
    }
    }
