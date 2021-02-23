<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Arctype;
use  App\Models\Arctype as ArctypeModel;
use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Admin\Actions\Post\Restore;
use App\Admin\Actions\Post\BatchRestore;




class ArctypeController extends AdminController
{


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Arctype(), function (Grid $grid) {
            $grid->column('id')->sortable()->filter();
            $grid->column('title','栏目名称')->tree();
            $grid->quickSearch(['id', 'title']);
            $grid->column('order');
            $grid->column('created_at');
            // $grid->typeid('栏目名称')->display(function ($typeid) {
            // $data =CategoryModel::where('id',$typeid)->value('typename');
            //return "{$data}";
            // });
            // 禁用详情按钮
            $grid->disableViewButton();
            //$grid->column('updated_at')->sortable();
            // 按id 进行筛选
            $grid->filter(function (Grid\Filter $filter) {
            //$filter->equal('id');
            $filter->scope('trashed', '回收站')->onlyTrashed();
            });

             $grid->setActionClass(Grid\Displayers\Actions::class);//行操作显示方式
             // 行删除恢复
             $grid->actions(function (Grid\Displayers\Actions $actions) {
             if (request('_scope_') == 'trashed') {
             $actions->append(new Restore(ArctypeModel::class));
              }
           });
             //批量恢复操作
             $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
            if (request('_scope_') == 'trashed') {
             $batch->add(new BatchRestore(ArctypeModel::class));
                  }
            });

             $grid->disableDeleteButton();
             $grid->disableEditButton();

             //禁止删除有子栏目的栏目
            $grid->actions(function (Grid\Displayers\Actions $actions) {

            $actions->append('  <a  title="添加子栏目" href="/admin/category/create?id='.$this->id.'" class="label bg-blue">添加子栏目</a>');

            $actions->append('  <a  title="编辑" href="/admin/category/'.$this->id.'/edit" class="label bg-green">编辑</a>');

            $dataid =ArctypeModel::where('parent_id',$this->id)->value('id');
            if(empty($dataid)){
               $actions->append('  <a  title="删除" href="javascript:void(0);" data-message="ID - '.$this->id.'" data-url="/admin/category/'.$this->id.'" data-action="delete" class="label bg-red">删除</a>');
            }



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
        return Show::make($id, new Arctype(), function (Show $show) {
            $show->field('id');
            $show->field('parent_id');
            $show->field('order');
            $show->field('typename');
            $show->field('typedir');
            $show->field('title');
            $show->field('description');
            $show->field('keywords');
            $show->field('is_write');
            $show->field('real_path');
            $show->field('litpic');
            $show->field('typeimages');
            $show->field('contents');
            $show->field('mid');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Arctype(), function (Form $form ) {

            $form->width(5, 2);
            $form->tab('基础信息', function (Form $form) {
            $form->display('id');
            $id=request()->get('id',0);
            $form->select('parent_id','父级栏目')->options(ArctypeModel::selectOptions())->default($id)->width(5, 2);

            $form->text('title','栏目名称')->required()->width(5, 2);
            $form->text('typedir')->required()->width(5, 2);
            $form->radio('dirposition')->options(['0' => '上级目录', '1'=> '根目录'])->default('1');
            $form->radio('mid')->options(['0' => '普通文档', '2'=> '产品文档', '1'=> '品牌文档'])->default('1');
            $form->text('order')->help('从小到大的顺序排序')->required()->width(5, 2);
            $form->text('seotitle','SEO标题')->width(5, 2);
            $form->textarea('description')->rows(5)->width(5, 2);
            $form->text('keywords')->width(5, 2);
            $form->radio('is_write')->options(['0' => '不允许', '1'=> '允许'])->default('1');
            //栏目路径处理
            $form->hidden('real_path');
            $form->saving(function (Form $form) {
            $pid=$form->parent_id;
            $typedir=$form->typedir;
            $dirposition=$form->dirposition;
            $data =ArctypeModel::where('id',$pid)->value('typedir');
            if ($dirposition==0){
              $real_path=$data.'/'.$typedir;
            }
            else{
               $real_path=$typedir;
            }

            // 等同于
            //$typename = $form->input('title')
           $form->real_path= $real_path;

            });


})->tab('高级选项', function (Form $form) {
           //限制上传宽度为100-600像素的图片
            $form->image('litpic')->width(5, 2)->autoUpload();
            $form->multipleImage('typeimages')->width(5, 2)->saving(function ($paths) {
                // 可以转化为由 , 隔开的字符串格式
                 return implode(',', $paths);

                // 也可以转化为json
                //return json_encode($paths);
            });

})->tab('栏目内容', function (Form $form) {

            $form->editor('contents')->height(500)->width(10, 1);
            $form->display('created_at');
            $form->display('updated_at');


            });

                $form->footer(function ($footer) {

                    // 去掉`查看`checkbox
                    $footer->disableViewCheck();

                    // 去掉`继续编辑`checkbox
                    $footer->disableEditingCheck();

                    // 去掉`继续创建`checkbox
                    $footer->disableCreatingCheck();
            });




  });

    }


}
