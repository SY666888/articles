<?php

namespace App\Admin\Forms;
use  App\Models\Arctype;
use  App\Models\Articlecreate;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Contracts\LazyRenderable;
use Illuminate\Http\Request;

class ResetTypeid extends Form implements LazyRenderable
{
    use LazyWidget;

    // 处理请求
    public function handle(array $input)
    {
        // id转化为数组
        $id = explode(',', $input['id'] ?? null);
        $typeid = $input['typeid'] ?? null;
        if (! $id) {
            return $this->response()->error('参数错误');
        }
        $titles =Articlecreate::query()->find($id);
        if ($titles->isEmpty()) {
            return $this->response()->error('文章不存在');
        }
        // 这里改为循环批量修改
        $titles->each(function ($title) use ($typeid) {
            $title->update(['typeid' => $typeid]);
        });

        return $this->response()->success('修改成功')->refresh();
    }

    public function form()
    {
        $this->select('typeid','所属栏目')->required()->options(Arctype::SelectOptions());
        // 设置隐藏表单，传递用户id
        $this->hidden('id')->attribute('id','reset-type-id');#reset-type-id,返回要一致
    }


}
