<?php

namespace App\Admin\Repositories;

use App\Models\Link as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Link extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
    /**
     * 获取连接类型
     * @return string[]
     */
    const CACHE_TAG = 'links:';
    //版本约定

    const TYPE_HOME = 0;//首页链接
    const TYPE_ALL = 1;//全站链接
    const TYPE_INNER = 2;//内页链接
    const TYPE_SPONSOR =3 ;//赞助商
    const TYPE_PARTNER = 4;//合作伙伴

    public static function getTypeLabels()
    {
        return [
            Link::TYPE_HOME => '首页链接',
            Link::TYPE_INNER => '内页链接',
            Link::TYPE_ALL => '全站链接',
            Link::TYPE_SPONSOR => '赞助商',
            Link::TYPE_PARTNER => '合作伙伴',
        ];
    }
    /**
     * 只查询正常状态的链接
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where(function ($query) {
            /** @var \Illuminate\Database\Eloquent\Builder $query */
            $query->whereNull('expired_at')
                ->orWhere('expired_at', '>', now());
        });
    }
}
