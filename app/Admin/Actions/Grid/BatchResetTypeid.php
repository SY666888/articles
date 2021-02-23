<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\ResetTypeid as ResetTypeidForm;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Grid\BatchAction;

class BatchResetTypeid extends BatchAction
{
    protected $title = '修改栏目';

    public function render()
    {
        // 实例化表单类
        $form = ResetTypeidForm::make();

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            // 因为此处使用了表单异步加载功能，所以一定要用 onLoad 方法
            // 如果是非异步方式加载表单，则需要改成 onShow 方法
            ->onLoad($this->getModalScript())
            ->button($this->title);
    }

    protected function getModalScript()
    {
        // 弹窗显示后往隐藏的id表单中写入批量选中的行ID
        return <<<JS
// 获取选中的ID数组
var key = {$this->getSelectedKeysScript()}

$('#reset-type-id').val(key);
JS;
    }
}
