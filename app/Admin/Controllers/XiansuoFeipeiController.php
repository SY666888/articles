<?php

namespace App\Admin\Controllers;
use App\Admin\Repositories\Phone;
use  App\Models\Phone as PhoneModel;
use  App\Models\Kehuxiansuo;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Admin\Grid\Displayers\RowActions;
use Zhuzhichao\IpLocationZh\Ip;
use App\Admin\Actions\Grid\ToolAction\PhoneImportAction;
use App\Admin\Actions\Grid\RowAction\DeviceTrackAction;
use Dcat\Admin\Widgets\Tab;
class  XiansuoFeipeiController  extends AdminController
{
    protected $title = '电话信息分配管理';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Phone(), function (Grid $grid) {
            $grid->column('id')->width('6%')->sortable();
            $grid->column('phone','电话');
            $grid->column('name','客户姓名');
            $grid->model()->with(['Kehuxiansuo']);
            $grid->column('Kehuxiansuo.tracer_id','跟单者')
                ->display(function ($tracer_id) {
               $user=Admin::user()->where('id',$tracer_id)->value('name');
               if(!empty($user)){ return   '<span class="label bg-success">'.$user.'</span>';}
               else {return '<span class="label bg-orange-2">未分配</span>';}
            })->setHeaderAttributes(['style' => 'color:#d71345']);
            $grid->column('area','归属地')->display(function ($area) {
                if(stristr($this->IP,'192.168')||stristr($this->IP,'127.0.0'))
                {$area=$this->IP;}
                else{
                    $area=Ip::find($this->IP);
                    $area= $area[0].'-'.$area[1].'-'.$area[2];
                }

                return $area;
            });


            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->scope('trashed', '回收站')->onlyTrashed();

            });

            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableBatchActions();
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableRowSelector();

            // 禁用
            $grid->disableToolbar();
            $grid->disableCreateButton();
            $grid->toolsWithOutline(false);
            $grid->actions(function (RowActions $actions) {
                if (Admin::user()->can('phone_feipei')) {
                    $actions->append(new DeviceTrackAction());
                }

            });

            $grid->header(function () {
                $tab = Tab::make();
                $tab->addLink('所有客户', '?source_id=0',$this->source_id==0 ? true : false);
                $tab->addLink('已分配', '?source_id=1',$this->source_id==1 ? true : false);
                $tab->addLink('未分配', '?source_id=2',$this->source_id==2 ? true : false);
                return $tab;
            });
            if ($this->source_id == 0) {
                $grid->model();
                $grid->column('created_at','创建时间')->width('10%');
            } elseif ($this->source_id == 1) {
                $grid->model()->whereIn('id',Kehuxiansuo::select('phone_id'));
                $grid->column('Kehuxiansuo.updated_at','分配时间')->width('10%');
            } else {
                $grid->model()->whereNotIn('id',Kehuxiansuo::select('phone_id'));
                $grid->column('created_at','创建时间')->width('10%');
            }

        });
    }
    public function __construct(Request $request)
    {
        $this->source_id = $request->source_id;
        return $this;
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
        return Show::make($id, new Kehuxiansuo(), function (Show $show) {
            $show->field('id');
            $show->field('phone');
            $show->field('name');
            $show->field('remark');
            $show->field('IP');
            $show->field('host');
            $show->field('referer');
            $show->field('state');
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
        return Form::make(new Kehuxiansuo(), function (Form $form) {
            $form->width(5, 2);
            $form->display('id');
            $form->text('phone_id','当前电话id');
            $form->text('tracer_id','跟踪者id');
            $form->text('remark_type','备注类型');

            $form->textarea('remark','备注')->rows(5);

            $form->switch('valid','信息是否有效')->default(1);

            $form->display('created_at');
            $form->display('updated_at');

        });
    }


}
