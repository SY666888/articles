<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Phone;
use  App\Models\Phone as PhoneModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Zhuzhichao\IpLocationZh\Ip;
use App\Admin\Actions\Grid\ToolAction\PhoneImportAction;
class PhoneController   extends AdminController
{

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Phone(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('phone')->display(function ($phone) {
                if (Admin::user()->isAdministrator()){
                    return $phone;
                }
                else{
                   return substr_replace($phone, '****', 3, 4);
                }

            });
            $grid->column('name');
            $grid->column('remark')->width('10%')->limit(5);
            $grid->column('IP')->width('5%');
            $grid->column('host')->width('5%')->hide();
            $grid->column('referer')->display(function ($referer) {
                if(stristr($referer,'baidu'))
                    $laiyuan='百度';
                               elseif(stristr($referer,'so.com'))
                                   $laiyuan='360';
                               elseif(stristr($referer,'sogou'))
                                   $laiyuan='搜狗';
                               elseif(stristr($referer,'sm.cn'))
                                   $laiyuan='神马';
                               else
                                   $laiyuan='其它';
             return  $laiyuan;

            })->width('5%');
            $grid->column('area','归属地')->display(function ($area) {
                if(stristr($this->IP,'192.168')||stristr($this->IP,'127.0.0'))
                {$area=$this->IP;}
                else{
                    $area=Ip::find($this->IP);
                    $area= $area[0].'-'.$area[1].'-'.$area[2];
                }

                return $area;
            });

            $grid->column('created_at')->width('10%');
            //$grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->scope('trashed', '回收站')->onlyTrashed();

            });

            $grid->disableViewButton();
            //$grid->enableDialogCreate();
            //$grid->disableBatchActions();
            //$grid->disableCreateButton();
            $grid->export();
            $grid->toolsWithOutline(false);
            $grid->tools([
                new PhoneImportAction()
            ]);

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
        return Show::make($id, new Phone(), function (Show $show) {
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
        return Form::make(new Phone(), function (Form $form) {
            $form->width(5, 2);
            $form->display('id');
            $form->text('phone');
            $form->text('name');
            $form->textarea('remark')->rows(5);
            $form->text('host');
            $form->text('referer');
            $form->switch('state')->default(1);

            $form->display('created_at');
            $form->display('updated_at');
            $form->hidden('ip');
            $form->saving(function (Form $form) {
            //$form->ip=request()->getClientIp().':'.request()->getPort();
            $form->ip=request()->getClientIp();
            //$form->referer=$_SERVER['HTTP_REFERER'];
            //$form->referer=str_limit(request()->session()->all()['referer'],100,'');
            });
        });
    }
}
