<?php

namespace App\Admin\Controllers;
use App\Admin\Repositories\Link;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Dcat\Admin\Http\Controllers\AdminController;
use Carbon\Carbon;
use App\Admin\Grid\Displayers\RowActions;
class LinkController extends AdminController
{
    protected $title = '友情链接管理';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid():Grid
    {
        return Grid::make(new Link(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title', '链接名称')->title();
            $grid->column('url','链接地址')->link();
            $grid->column('lianxi','联系方式');
            //$grid->column('state','链接状态')->switch();
            $grid->column('state','状态')->using([0 => '废弃', 1 => '正常'])->label([
                'default' => 'primary', // 设置默认颜色，不设置则默认为 default
                0 => 'dark60',
                1 => 'primary',
            ]);

            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('linktype', '类型', Link::getTypeLabels());
            });
            $grid->column('linktype', '类型')->using(Link::getTypeLabels());
            //$grid->column('beizhu','备注');

            $grid->column('logo','链接图片')->image('',50, 50);
            //$grid->column('created_at');
            $grid->column('updated_at')->sortable();
            //禁用行操作
            $grid->disableRowSelector();
            //开启弹窗
            $grid->enableDialogCreate();
            $grid->disableViewButton();
            $grid->paginate(10);
            //筛选器
            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id', 'ID');
                $filter->like('title', '名称');
                $filter->like('url', 'Url');
                //顶部筛选
                $filter->scope('expired_at', '已经到期')->where('expired_at', '<', Carbon::now());
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Link(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('url');
            $show->field('lianxi');
            $show->field('state');
            $show->field('linktype');
            $show->field('beizhu');
            $show->field('logo');
            $show->field('expired_at');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Link(), function (Form $form) {
            $form->display('id');
            $form->text('title', '链接名称')->required();
            $form->url('url', '链接地址')->required();
            $form->text('lianxi','联系方式');
            $form->switch('state','状态')->default(1)->saving(function ($state){
                if(request('expired_at')<now()){
                    $state=0;
                }
                return $state;
            });
            $form->select('linktype', '链接类型')->options(Link::getTypeLabels())->required()->default(Link::TYPE_HOME);
            $form->textarea('beizhu','备注')->rows(5);
            $form->image('logo','图片')->accept('jpg,png,gif,jpeg')->maxSize(512)
                ->autoUpload()->help('大小不要超过512K')->uniqueName()
                ->move('images/links');
            $form->datetime('expired_at', '过期时间');

            $form->display('created_at');
            $form->display('updated_at');

        });
    }
}
