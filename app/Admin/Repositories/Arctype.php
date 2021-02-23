<?php

namespace App\Admin\Repositories;

use App\Models\Arctype as ArctypeModel;
use Dcat\Admin\Repositories\EloquentRepository;

class Arctype extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = ArctypeModel::class;
    // 栏目下拉框选择函数
    public static function getSelectOptions($mid)
    {
        //$options =DB::table('ArctypeModel')->select('id','title','parent_id')->get();
        //$options = ArctypeModel::where('parent_id',1)->orwhere('id',1)->orwhere('id',3)->get();
        $options = ArctypeModel::where('mid',$mid)->where('parent_id','<>',0)->orderBy ('mid', 'asc')->get();
        $selectOption = [];
        foreach ($options as $option){
            $id=$option->id;
            $datas=ArctypeModel::where('parent_id',$id)->value('id');
            if ($datas){
                $selectOption[$option->id] = '└─  '.$option->title;
            }
            else {
                $selectOption[$option->id] = '　　├─ ' . $option->title;
            }
            }
        return $selectOption;
    }
    public static function getSelectOptionsall()
    {
        //$options = \DB::table('ArctypeModel')->select('id','title as text')->get();
        $options = ArctypeModel::orderBy ('mid', 'asc')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id]=$option->title;
        }


        return $selectOption;
    }

}
