<?php

namespace App\Admin\Actions\Grid\RowAction;
use  App\Models\Kehuxiansuo;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\RowAction;

class ResetAction extends RowAction
{
    protected $title = '🔨 恢复';

    /**
     * 处理动作逻辑
     * @return Response
     */
    public function handle()
    {
        // 获取当前行ID
         $id = $this->getKey();
        if (!Admin::user()->can('phone_genzong.reset')) {
            return $this->response()
                ->error('你没有权限执行此操作！')
                ->refresh();
        }
        // 获取当前行ID
        $valid = Kehuxiansuo::where('id',$id)->first();
         if (isset($valid))
         {
             $valid->update([
                 'valid'=>-1,
                 'remark_type'=>' ',
                 'remark'=>' ',
                 'num'=>0,
         ]);
         }
        return $this->response()
            ->success('恢复成功！')
            ->refresh();

    }


    /**
     * 对话框
     * @return string[]
     */
    public function confirm(): array
    {
        return ['确认要恢复吗？', '恢复的同时将会删除所有跟进记录！'];
    }
}
