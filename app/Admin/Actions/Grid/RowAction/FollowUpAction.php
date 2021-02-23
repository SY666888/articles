<?php

namespace App\Admin\Actions\Grid\RowAction;

use App\Admin\Forms\FollowUpForm;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Widgets\Modal;
use  App\Models\Phone;
use  App\Models\Kehuxiansuo;
class FollowUpAction extends RowAction
{
    protected $title ='💼 跟进';
    /**
     * 渲染模态框
     * @return Modal|string
     */
    public function render()
    {
        if (!Admin::user()->can('FollowUp')) {
            return '你没有权限执行此操作！';

        }


        // 实例化表单类并传递自定义参数
        $form = FollowUpForm::make()->payload(['id' => $this->getKey()]);
        $phone=Phone::where('id',$this->getRow()->phone_id)->value('phone');
        return Modal::make()
            ->lg()
            ->title('对电话为: ' .$phone. '的信息进行跟进处理')
            ->body($form)
            ->button($this->title);
    }

}
