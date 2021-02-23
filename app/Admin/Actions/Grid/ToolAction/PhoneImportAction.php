<?php

namespace App\Admin\Actions\Grid\ToolAction;

use App\Admin\Forms\PhoneImportForm;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Widgets\Modal;

class PhoneImportAction extends AbstractTool
{
    protected $title = '<a class="btn btn-primary btn-white waves-effect" ><i class="feather icon-share"></i>导入数据</a>';

    /**
     * 渲染模态框
     * @return Modal|string
     */
    public function render()
    {
        return Modal::make()
            ->lg()
            ->body(new PhoneImportForm())
            ->button($this->title);
    }
}
